<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		@php
			use Illuminate\Support\Facades\DB;
			use Carbon\Carbon;
			$product_detail = DB::table('order_details')->where('order_id', $data['order_id'])->get();	

		@endphp
        <div style="margin:0px auto; width:700px;">
            <div style="padding: 20px 0px; text-align:center;background:#b8632333;width:700px;">
                <img  src="https://pos.azoka.com.bd/logo/Azoka-01.png" alt="" style="width: 120px; height:auto; object-fit:contain;margin:0 auto;">
            </div>
            <div style="padding: 10px;width:678px;border:1px solid #b8632333;line-height: 28px;">
				 <p>Hello  <b>{{$data['user_name']}}, </b> Your order placed successfully.</p>
	            <h2 style="margin-bottom: 0">Product Details</h2>
				<table style="margin-left: auto; margin-right: auto;border: 1px solid #b8632333;padding: 15px;" width="100%" cellspacing="0" cellpadding="0">
						<tbody>
							<tr style="height: 28px;">
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 40%; height: 28px; text-align: left; background-color: #ffffff;"><span style="background-color: #ffffff; color: #000000;"><strong>Name</strong></span></td>
								<td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 10%; height: 28px; background-color: #ffffff;"><span style="background-color: #ffffff; color: #000000;"><strong>Price</strong></span></td>
								<td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 10%; height: 28px; background-color: #ffffff;"><span style="background-color: #ffffff; color: #000000;"><strong>Quantity</strong></span></td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 40%; height: 28px; text-align: right; background-color: #ffffff;"><span style="background-color: #ffffff; color: #000000;"><strong>Sub Total</strong></span></td>
							</tr>

							@php
								if($data['tran_id']){ 
									$order = DB::table('orders')->where('transaction_id', $data['tran_id'])->first();
									if($order->id){
										$order_details = DB::table('order_details')->where('order_id', $order->id)->get();
									}
								}
							@endphp
							@foreach ($order_details as $details)
								@foreach (DB::table('products')->where('id', $details->product_id)->get() as $product)
								<tr style="height: 7.60001px;">
									@php
										$single_product_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + get_varianPrice($product->id, $product->is_active);
									@endphp
									<td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 30%; height: 7.60001px;">{{$product->name}}</td>
									<td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 10%; height: 7.60001px;">{{ $single_product_price }}</td>
						
									<td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 30%; height: 7.60001px;">{{$details->count}}</td>
									<td style="text-align: right;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; width: 30%; height: 7.60001px;">{{ $single_product_price*$details->count }}</td>
								</tr>
								@endforeach
							@endforeach
							<tr class="total" style="height:30px; border-top:1px solid #b8632333;">
								<td style="font-family: 'arial'; font-size: 12px;  border-top: 1px solid #f6f6f6; margin: 0px; padding: 9px 0px; width:20%; height: 30px;"></td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top: 1px solid #f6f6f6; margin: 0px; padding: 9px 0px; font-weight: bold; width: 30%; height: 30px; text-align: right;">Sub Total: </td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top: 1px solid #f6f6f6; margin: 0px; padding: 9px 0px; font-weight: bold; width: 50%; height: 30px; text-align: right;" align="right">{{$data['currency']}} {{ $data['sub_total'] }}</td>
							</tr>
							<tr class="total" style="height:30px;">
								<td style="font-family: 'arial'; font-size: 12px; margin: 0px; padding: 9px 0px; width:20%; height: 30px;"></td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; font-weight: bold; width: 30%; height: 30px; text-align: right;">  Shipping Cost: </td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle;  margin: 0px; padding: 9px 0px; font-weight: bold; width: 50%; height: 30px; text-align: right;" align="right">{{$data['currency']}} {{$data['shipping_cost']}}</td>
							</tr>
							<tr class="total" style="height: 30px;">
								<td style="font-family: 'arial'; font-size: 12px; margin: 0px; padding: 9px 0px; width:20%; height: 30px;"></td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; font-weight: bold; width: 30%; height: 30px; text-align: right;"> Total: </td>
								<td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 9px 0px; font-weight: bold; width: 50%; height: 30px; text-align: right;" align="right">{{$data['currency']}} {{$data['amount']}}</td>
							</tr>

							
						</tbody>
				</table>
				<br>
				<h2 style="margin-bottom: 0">Shipping Address</h2>
				<hr>
				<p><strong>Division: </strong>  {{$data['state']}} </p>
				<p><strong>District: </strong> {{$data['district']}}</p>
				<p><strong>Post Code: </strong> {{$data['postal_code']}}</p>
				<p><strong>Address: </strong> {{$data['address']}}</p>
				<p><strong>Phone: </strong> {{$data['user_phone']}}</p>
				<p><strong>Email: </strong> {{$data['user_email']}}</p>
				<p><strong>Date: </strong> {{ Carbon::now() }}</p>
				<br>
            </div>
            <div style="background:#b8632333;color:#000; padding: 20px 0px; width:700px;margin: 0 auto;">
            	<p style="color:#000; margin: 0px 0px 0px 10px">Stay connect with <a style="color:#000;" href="https://azoka.com.bd/">azoka.com.bd</a> </p> 
            </div>
        </div>
	</body>
</html>
