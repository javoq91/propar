<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\ActivitylogFacade as Activity;
use EmilioBravo\Lotes\Lotes;

class PaymentEventSubscriber {

  /**
   * When a payment is updated
   */
  public function onUpdate($payment)
  {
    Auth::loginUsingId(1);
    $order = $payment->order;
    Auth::loginUsingId($order->user_id);

    if($payment->status=='paid' || $payment->status=='partially_paid' || $payment->status == 'rolled_back'){

      $sku = json_decode($order->items[0]->sku);
      $user = $order->user;

      if($payment->status=='paid' || $payment->status=='partially_paid'){
        $api_response = Lotes::pago($sku->transaccion_id,$payment->id,$sku->codigo_lote,$sku->cantidad_cuotas,$sku->monto_total);
        if($api_response['codigo'] == '200'){
          \Spatie\Activitylog\ActivityLogFacade::log('<span class="label label-info">Payment sent to CBI</span> <a href="/admin/payments/' . $payment->id . '/edit">' . $payment->id . ' ' . $order->name . '</a>');
        }else{
          \Spatie\Activitylog\ActivityLogFacade::log('<span class="label label-danger">Payment NOT sent to CBI</span> <a href="/admin/payments/' . $payment->id . '/edit">' . $payment->id . ' ' . $order->name . '</a>');
        }
      }elseif($payment->status == 'rolled_back'){
        $api_response = Lotes::reversion($payment->id);
        if($api_response['codigo'] == '200'){
          \Spatie\Activitylog\ActivityLogFacade::log('<span class="label label-info">Payment reversed to CBI</span> <a href="/admin/payments/' . $payment->id . '/edit">' . $payment->id . ' ' . $order->name . '</a>');
        }else{
          \Spatie\Activitylog\ActivityLogFacade::log('<span class="label label-danger">Payment NOT reversed to CBI</span> <a href="/admin/payments/' . $payment->id . '/edit">' . $payment->id . ' ' . $order->name . '</a>');
        }
      }


    }
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param  Illuminate\Events\Dispatcher  $events
   * @return array
   */
  public function subscribe($events)
  {
    $events->listen('payment.update', '\PaymentEventSubscriber@onUpdate');
  }

}
