<?php
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use EmilioBravo\Ecommerce\PaymentGateway;
use EmilioBravo\Ecommerce\Order;
use EmilioBravo\Ecommerce\OrderItem;
use EmilioBravo\Ecommerce\Payment;
use Omnipay\Omnipay;

class PaymentsController extends BaseController {

	/**
	 * Add to cart and redirect to it
	 *
	 */
	protected function addToCart($lote_id)
	{
        Cart::destroy();
		$lote = Cache::remember('lote_' . $lote_id, 1, function() use ($lote_id)
		{
			$consulta_response = Lotes::consulta($lote_id);
			return $consulta_response;
		});
		$id_transaccion = $lote[0]['id_transaccion'];
    $qty = 1;
    $rows = Cart::search(['id' => $id_transaccion]);

    if($row_id = $rows[0]){ // Check if item already exists in cart

        $cart_item = Cart::get($row_id);
        $status = 'ok';
        $message = '';

        Cart::update($row_id,$qty);

    }else{

				$status = 'ok';
				$message = '';
        // Format array of required info for item to be added to basket...
        $items = array(
            'id' => $id_transaccion,
            'name' => 'Lote ' . $lote[1][0]['codigo_lote'] . ' cuota: ' . $lote[1][0]['detalle_cuotas'][0]['numero_cuota'],
            'price' => $lote[1][0]['detalle_cuotas'][0]['monto_total_a_pagar'],
            'qty' => $qty,
						'options' => [
							'codigo_lote' => $lote[1][0]['codigo_lote'],
							'cantidad_cuotas' => 1,
							'monto_total' => $lote[1][0]['detalle_cuotas'][0]['monto_total_a_pagar']
						]
        );
        // Make the insert...
        Cart::add($items);
        $rows = Cart::search(['id' => $id_transaccion]);
        $row_id = $rows[0];
    }

    $cart_item = Cart::get($row_id);

		if(Request::ajax()){

			return App::make('PaymentsController')->generateOrder();

		}else{

			return Redirect::to('cart');

		}

	}

	/**
	 * Create order and send to PaymentGateway
	 *
	 */

	 function generateOrder()
	{

		if(!$user = Confide::user()){
			$user = JWTAuth::parseToken()->toUser();
		}

		// Check if cart has items
		if(Cart::count()){

		    $gateway = PaymentGateway::find(2);

		    // Validate gateway

		    if($gateway && $gateway->status ==='enabled'){

					$price = Cart::total();

					$order = new Order;
					$order->status = 'new';
					$order->name = $user->name;
					$order->user_id = $user->id;
					$order->user_email = $user->email;
					$order->document_number = $user->document_id;

					$order->payment_method_id = $gateway->id;
					$order->payment_method_name = $gateway->name;

					$total = Cart::total();
					$total_without_tax = ($total/(1+(Config::get('ecommerce::tax')/100)));
					$tax_total = $total - $total_without_tax;

					$order->total = $total;
					$order->tax_total = $tax_total;
					$order->total_without_tax = $total_without_tax;

					if($order->save()){

							foreach (Cart::content() as $item) {

								$sku = json_encode([
									'transaccion_id' => $item->id,
									'codigo_lote' => $item->options['codigo_lote'],
									'cantidad_cuotas' => $item->options['cantidad_cuotas'],
									'monto_total' => $item->options['monto_total']
								]);

                                $order_item = new OrderItem;
                                $order_item->sku = $sku;
                                $order_item->name = $item->name;
                                $order_item->qty = $item->qty;
                                $order_item->price = $item->price;
                                $order_item->subtotal = $item->subtotal;
                                $order->items()->save($order_item);
							}

							Cart::destroy();

							Session::save();

							$order->status = 'awaiting_payment';
							$order->save();

							$order->items = OrderItem::where('order_id','=',$order->id)->get();
							//Event::fire('order.create', ['order' => $order]);

							// Create payment process
							$payment_process = new Payment();
							$payment_process->order_id = $order->id;
							$payment_process->payment_gateway_id = $gateway->id;
							$payment_process->status = 'awaiting_auth';
							$payment_process->save();

							switch ($gateway->id) {
									case 1:

											$payment_process->status = 'awaiting_payment_cash_on_delivery';
											$payment_process->save();

											return Redirect::to('/orders/' . $order->id)->with('success', 'Su orden ha sido recibida y está siendo preparada.');

											break;

									case 2:
											$gateway = Omnipay::create('Bancard');
											$gateway->setTestMode($_ENV['bancard_test_mode']);
											$gateway->setPublicKey($_ENV['bancard_public_key']);

											$amount = number_format($order->total,2,'.','');
											$shop_process_id = $payment_process->id;
											$currency = "PYG";

											$generated_token = md5($_ENV['bancard_private_key']. $shop_process_id . $amount . $currency);

											if(Request::ajax()){
												$return_url = URL::to('/orders/redirect');
											}else{
												$return_url = URL::to('/orders/' . $order->id);
											}

											$data =
													[
													'token' => $generated_token,
													'shop_process_id' => $shop_process_id,
													'currency' => $currency,
													'amount' => $amount,
													'additional_data' => '',
													'description' => '#' . $order->id . ' ' . Settings::get('title'),
													'return_url' => $return_url,
													'cancel_url' => URL::to('/orders/' . $order->id)
													];

											$response = $gateway->purchase($data)->send();

											if ($response->isSuccessful()) {
													$payment_process->status = 'auth_success';
													$payment_process->transaction_id = $response->getTransactionId();
													$payment_process->save();

													if ($response->isRedirect()) {
															// redirect to offsite payment gateway
															if(Request::ajax()){

																$redirect_url = $response->getRedirectUrl();

																return Response::json(['status'=> 'ok', 'operation'=> ['redirect_url' => $redirect_url]]);

															}else{
																$response->redirect();
															}
													}else{
															// response
															dd($response);
													}
											} else {
													$payment_process->status = 'auth_error';
													$payment_process->gateway_response = $response->getMessage();
													$payment_process->save();
													// TODO: Redirect with error
											}

											break;
									case 3:

											// PayPal
											//return Redirect::to('/orders/create')->with('error', 'Este medio de pago no está disponible.');

											break;
									case 4:

											$payment_process->status = 'awaiting_payment_giros_tigo';
											$payment_process->save();

											return Redirect::to('/orders/' . $order->id)->with('success', 'Su orden ha sido recibida, siga las instrucciones para pagar vía Giros Tigo.');

											break;
									case 5:

											$payment_process->status = 'awaiting_payment_mpos_on_delivery';
											$payment_process->save();

											return Redirect::to('/orders/' . $order->id)->with('success', 'Su orden ha sido recibidaa y está siendo preparada.');

											break;
									case 6:

											$payment_process->status = 'awaiting_payment_envios_personal';
											$payment_process->save();

											return Redirect::to('/orders/' . $order->id)->with('success', 'Su orden ha sido recibida, siga las instrucciones para pagar vía Envíos Personal.');

											break;
							}

					}else{

							return Redirect::to('/orders/create')->with('error', 'Su orden no ha sido procesada');

					}

			$cart = Cart::content();
			return View::make('ecommerce::site/orders/create', compact('title','cart'));



		    }else{

		        return Redirect::to('/orders/create')->with('error', 'Ha ocurrido un error con el medio de pago seleccionado. Por favor pruebe con otro.');

		    }
		}else{

		    return Redirect::to('/orders/create')->with('warning', 'Su carrito está vacío');
		}

	}

}
