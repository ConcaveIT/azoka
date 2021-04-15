<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
        <style>
            p{
                margin: 0px;
                font-size: 14px;
            }
            .created{
                border:1px solid #000;
                width: 250px; 
                text-align:center;
                display:inline-block;
                border:1px solod #00000033; 
                padding:2px;font-size:14px;
                height: 80px;
            }
            .created_parent{
                margin: 0 auto;
                width: 500px;
            }
            .footer{
                padding: 15px 10px;
            }
            .twobox{
                width: 100%;
            }
            p{
                line-height:17px;
            }
        </style>

	</head>
	<body>
        <div style="width:100%;border:1px solid #b8632333;">
            <div style="padding: 30px;border:1px solid #b8632333;line-height: 28px;">
                <div style="width:100%; height:150px;">
                    <div style="width:30%; float: left;">
                        <img  src="https://pos.azoka.com.bd/logo/Azoka-01.png" alt="" style="width:120px; height:auto; object-fit:contain;">
                        <p style="margin: 0;">Name: {{ $order->name }}</p>
                        <p style="margin: 0;">Phone: {{ $order->phone }}</p>
                        <p style="margin: 0;">Email: {{ $order->email }}</p>
                        @if($order->shipping_address)
                        <p style="margin: 0;">Shipping Address: {{ $order->shipping_address }}</p>
                        @else
                        <p style="margin: 0;">Shipping Address: {{ $order->address }}</p>
                        @endif
                    </div>
                    <div style="width: 68%;float: right; text-align:right;">
                        <p style="margin: 0;">Azoka Limited</p>
                        <p style="margin: 0;">Email: shop@azoka.com.bd</p>
                         <p style="margin: 0;">Call us: +8809614778899</p>	
                        <p>2nd Floor, House-54/A, Road-132, <br> Gulshan Circle-1, Dhaka-1212</p>
                        <div style="margin-top:15px;"></div>
                        <p> <strong>Order ID: </strong> {{ $order->id }}</p>
                    </div>
                </div>
                @php
                    use Carbon\Carbon;
                @endphp
                <div class="twobox">
                    <div class="created_parent">
                        <div class="created">
                            <b>Shipment Created</b>
                            <p>{{ date('d M Y') }}</p>
                            <p>{{ date('h:i A') }}</p>
                        </div>
                        <div  class="created">
                            <b>Preferred Delivery Time</b>
                            @if($order->shipping_cost <= 80)
                                <p style="margin-top: -5px; padding:0;">{{ date('d M Y', strtotime(Carbon::now()->addDays(1))) }}</p>
                            @endif
                            @if($order->shipping_cost > 80)
                                <p style="margin-top: -5px; padding:0;">{{ date('d M Y', strtotime(Carbon::now()->addDays(3))) }}</p>
                            @endif
                            <p style="padding:0;">12 PM</p>
                        </div>
                    </div>
                </div>
                <table style="border: 1px solid #b8632333;padding: 5px 15px;" width="100%">
                        <tbody>
                            <tr style="height: 8px;">
                                <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 50%; height: 28px; text-align: left; background-color: #ffffff;"><p style="background-color: #ffffff; color: #000000;"><strong>Name</strong></p></td>
                                <td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 15%; height: 28px; background-color: #ffffff;"><p style="background-color: #ffffff; color: #000000;"><strong>Price</strong></p></td>
                                <td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 15%; height: 28px; background-color: #ffffff;"><p style="background-color: #ffffff; color: #000000;"><strong>Quantity</strong></p></td>
                                <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 20%; height: 28px; text-align: right; background-color: #ffffff;"><p style="background-color: #ffffff; color: #000000;"><strong>Sub Total</strong></p></td>
                            </tr>
                            @foreach ($order->order_details as $data)
                                @php
                                    $color  = DB::table('product_variants')->find($data->color_id);
                                    $size   = DB::table('product_variants')->find($data->size_id);
                                    $weight = DB::table('product_variants')->find($data->weight_id);
                                    $type   = DB::table('product_variants')->find($data->type_id);

                                    $original_price = price_after_offer_or_not($data->product->id, $data->product->price, $data->product->starting_date, $data->product->last_date);
                                    $color_price  = $color->additional_price ?? 0;
                                    $size_price   = $size->additional_price ?? 0;
                                    $weight_price = $weight->additional_price ?? 0;
                                    $type_price   = $type->additional_price ?? 0;
                                    $single_product_price = $original_price+$color_price+$size_price+$weight_price+$type_price;
                                @endphp 
                                <tr style="height: 4.60001px;border-bottom:1px solid #ff8f39d4;">
                                    <td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 50%; height: 4.60001px;">{{ $data->product->name }}</td>
                                    <td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 15%; height: 4.60001px;"> {{ $single_product_price }}</td>
                                    <td style="text-align: left;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 15%; height: 4.60001px;">{{ $data->count }}</td>                        
                                    <td style="text-align: right;font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0px; padding: 2px 0px; width: 20%; height: 4.60001px;">{{ ($original_price+$color_price+$size_price+$weight_price+$type_price)*$data->count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
                <div style="width: 100%; padding:0px;text-align:right;"> <p style="margin:0px;"> <strong>Subtotal: </strong> {{ $order->currency}} {{  $order->sub_total }}  </p> </div>
                <div style="width: 100%; padding:0px;text-align:right;"> <p style="margin:0px;padding-top:10px;"> <strong>Shipping Cost: </strong> {{ $order->currency}} {{ $order->shipping_cost??0 }} </p> </div>
                <div style="width: 100%; padding:0px;text-align:right;"> <p style="margin:0px;padding-top:10px;"> <strong>Total: </strong> {{ $order->currency}} {{ $order->amount }} </p> </div>
            </div>
            <div class="footer">
                <p style="color:#000;"> Thank you for ordering from azoka.com.bd.  Stay connect with <b>azoka.com.bd</b> </p>
            </div>
        </div>
	</body>
</html>