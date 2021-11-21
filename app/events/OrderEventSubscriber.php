<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\ActivitylogFacade as Activity;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class OrderEventSubscriber {

  /**
   * When a order is updated
   */
  public function onUpdate($order)
  {
    return;
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param  Illuminate\Events\Dispatcher  $events
   * @return array
   */
  public function subscribe($events)
  {
    $events->listen('order.update', '\OrderEventSubscriber@onUpdate');
  }

}
