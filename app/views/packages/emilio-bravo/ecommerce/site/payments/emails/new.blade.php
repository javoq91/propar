<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Hemos recibido su pago</title>
        <style media="all" type="text/css">

	    </style>
</head>
<body><center>

		<table cellpadding="0" cellspacing="0" width="655" style="border:1px solid #c5c5c5">
			<tbody><tr>
				<td>

					<table border="0" cellpadding="0" cellspacing="0" width="655">
						<tbody>
						<tr>
							<td align="center" style="padding-top:20px">


								<table width="600" border="0" cellpadding="0" cellspacing="0">
									<tbody>
                    <tr>
                      <td style="text-align:center;"><img src="http://www.propar.com.py/img/logo_propar.png" alt="Logo PROPAR"/></td>
                    </tr>
                    <tr>
										<td height="22" style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:12px;text-transform:uppercase;font-weight:bold;color:#000;height:22px;padding-left:20px">Hemos recibido el pago de su cuota. Puede ver el estado de su lote ingresando a <a href="http://www.propar.com.py/lotes/{{ str_replace('/','-',json_decode($order['items'][0]['sku'])->codigo_lote) }}">http://www.propar.com.py/lotes/{{ str_replace('/','-',json_decode($order['items'][0]['sku'])->codigo_lote) }}</a></td>
									</tr>
								</tbody></table>

								<table width="600" border="0" cellpadding="0" cellspacing="0">
									<tbody><tr>
										<td height="22" style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:12px;text-transform:uppercase;font-weight:bold;color:#000;height:22px;padding-left:20px">Pedido #:</td>
										<td height="22" style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:uppercase;font-weight:normal;color:#000"> <a href="tel:49398273" value="+59549398273" target="_blank">{{ $order['id'] }}</a></td>
									</tr>
									<tr>
										<td height="30" style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:12px;text-transform:uppercase;font-weight:bold;color:#000;width:100px;padding:0 0 8px 20px;border-bottom:1px solid #dadada">Fecha:</td>
										<td height="30" style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:uppercase;font-weight:normal;color:#000;width:500px;padding:0 0 8px 0;border-bottom:1px solid #dadada">  {{ $order['created_at'] }}</td>
									</tr>
								</tbody></table>

                <br>


								<table width="600" border="0" cellpadding="0" cellspacing="0">
									<tbody><tr>
										<td style="text-align:left;font-family:Arial,Helvetica,san-serif;font-size:12px;text-transform:uppercase;font-weight:bold;color:#000;padding-left:20px;background-color:#f1ede6;height:27px">Detalle</td>
									</tr>
								</tbody></table>
								<table width="600" height="25" border="0" cellpadding="0" cellspacing="0">
									<tbody><tr>
										<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:capitalize;font-weight:normal;color:#000;width:470px;text-align:left;border-bottom:1px solid #dadada;height:25px">Items</td>
										<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:capitalize;font-weight:normal;color:#000;width:80px;text-align:center;border-bottom:1px solid #dadada">Precio</td>
										<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:capitalize;font-weight:normal;color:#000;width:50px;text-align:center;border-bottom:1px solid #dadada">Cantidad</td>
										<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:capitalize;font-weight:normal;color:#000;width:50px;text-align:center;border-bottom:1px solid #dadada">Subtotal</td>

									</tr>




						                        @foreach($order['items'] as $order_item)
									<tr>
									<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;font-weight:normal;color:#000;width:50px;text-align:left;border-bottom:1px solid #dadada;padding:10px 0">
									<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tbody><tr>
                  <td style="font-family:Arial,Helvetica,san-serif;padding-left:0px"><span style="font-family:Arial,Helvetica,san-serif;font-size:12px;text-transform:uppercase;font-weight:bold;color:#000">{{ $order_item['name'] }}</span>
									<br>
									<span style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:capitalize;font-weight:normal;color:#6b6b6b">Transaccion id N&ordm; {{ json_decode($order_item['sku'])->codigo_lote }}</span></td>
									</tr>
									</tbody></table>
									</td>
									<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;font-weight:normal;color:#4e4e4e;width:50px;text-align:center;border-bottom:1px solid #dadada">{{ Currency::format($order_item['price'], 'PYG') }}</td>
									<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;font-weight:normal;color:#4e4e4e;width:50px;text-align:center;border-bottom:1px solid #dadada">{{ $order_item['qty'] }}</td>
									<td style="font-family:Arial,Helvetica,san-serif;font-size:11px;font-weight:normal;color:#4e4e4e;width:50px;text-align:center;border-bottom:1px solid #dadada">{{ Currency::format($order_item['subtotal'], 'PYG') }}</td>
									</tr>


						                        @endforeach

								</tbody></table>

								<table width="400" border="0" cellpadding="0" cellspacing="0" align="right" style="padding-right:25px">
									<tbody>
									<tr>
										<td height="18" style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:uppercase;font-weight:bold;color:#000;text-align:right;line-height:18px;height:18px">Total</td>
										<td height="18" align="left" style="font-family:Arial,Helvetica,san-serif;font-size:11px;text-transform:uppercase;font-weight:bold;color:#4e4e4e;text-align:right;width:80px;border-bottom:1px solid #dadada;line-height:18px;height:18px">{{ Currency::format($order['total'], 'PYG') }}</td>
									</tr>
								</tbody></table>


							</td>
						</tr>
					</tbody></table>

				</td>
			</tr>
		</tbody>
	</table>
</center>
</body>
</html>
