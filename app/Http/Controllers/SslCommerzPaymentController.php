<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use App\Order;
use App\OrderDetails;
use App\Product;
use App\Product_Warehouse;
use App\ProductVariant;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SslCommerzPaymentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:customer')->only([
            'exampleHostedCheckout', 'index',
        ]);
    }

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    


    public function exampleHostedCheckout()
    {
        if (session()->has('shipping_cost') && session()->has('cart')) {
            return view('frontend.checkout');
        } else {
            $cart = session()->get('cart');
            return redirect('/cart')->with('msg', 'Please add products and choose shipping location');
        }

    }

    
 public function apiindex(Request $request){
        $customer = Customer::find($request->user_id);
        $total = $request->cart_total;
        $cart =  $request->cart;
        $count = count($cart) ?? [];
        if ($count <= 0 || $total <= 0) {
            return response()->json(['msg' => 'An error occurred while processing your order!'], 404);
        }
        if ($request->payment_method != 'ssl' && $request->payment_method != 'cod') {
            return response()->json(['msg' => 'An error occurred while processing your order!'], 404);
        }
        if ($request->shipping_address) {
            $request->validate([
               'shipping_address' => 'required',
               'shipping_city' => 'required',
               'shipping_district' => 'required',
               'shipping_state' => 'required',
               'shipping_postal_code' => 'required',
            ]);
        }
        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
        ]);
        $notes = $request->notes;
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  $request->name ?? "";
        $post_data['cus_email'] =  $request->email ?? "";
        $post_data['cus_add1'] = $request->address ?? "";
        $post_data['cus_add2'] = $request->address ?? "";
        $post_data['cus_city'] =  $request->city ?? "";
        $post_data['cus_state'] = $request->state ?? "";
        $post_data['cus_postcode'] = $request->postal_code ?? "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] =  $request->phone_number ?? "";;
        $post_data['cus_fax'] = "";
        # SHIPMENT INFORMATION
        $post_data['ship_name'] =  $request->shipping_name ?? $request->name;
        $post_data['ship_add1'] =  $request->shipping_address ?? $request->address;
        $post_data['ship_add2'] = $request->shipping_address ?? $request->address;
        $post_data['ship_city'] = $request->shipping_city ?? $request->city;
        $post_data['ship_district'] = $request->shipping_district ?? $request->district;
        $post_data['ship_state'] = $request->shipping_state ?? $request->state;
        $post_data['ship_postcode'] = $request->shipping_postal_code ?? $request->postal_code;
        $post_data['ship_phone'] = $request->shipping_phone_number ?? $request->phone_number;
        $post_data['ship_email'] = $request->shipping_email ?? $request->email;
        $post_data['ship_country'] = "Bangladesh";
        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Mridha Enterprise";
        $post_data['product_category'] = "Mridha Enterprise";
        $post_data['product_profile'] = "Mridha Enterprise";
        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";
        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['ship_name'],
                'email' => $post_data['ship_email'],
                'phone' => $post_data['ship_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['ship_add1'],
                'city' => $post_data['ship_city'],
                'district' => $post_data['ship_district'],
                'state' => $post_data['ship_state'],
                'postal_code' => $post_data['ship_postcode'],
                'country' => 'Bangladesh',
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'customer_id' => $customer->id,
                'origin' => 'Website',
                'notes' => $notes,
                'created_at' => now(),
            ]);
			$order = Order::where('transaction_id', $post_data['tran_id'])->first();

			for ($i = 0; $i < $count; $i++) {
				OrderDetails::create([
					'order_id'   => $order->id,
					'product_id' => $cart[$i]['product_id'],
					'count'      => $cart[$i]['count'],
					'color_id'   => $cart[$i]['color_id'],
					'size_id'    => $cart[$i]['size_id'],
					'weight_id'  => $cart[$i]['weight_id'],
					'type_id'    => $cart[$i]['type_id'],
					'amount'    => $post_data['total_amount']
				]);
				
				$warehouse = DB::table('product_warehouse')->where('product_id', $cart[$i]['product_id'])->first();
				$product = Product::find($cart[$i]['product_id']);
				$warehouse_data = DB::table('product_warehouse')->where([
					['product_id', $product->id],
					['warehouse_id', $warehouse->warehouse_id],
				]);

				$product_quantity = $product->qty - $cart[$i]['count'];
				$warehouse_count = $warehouse_data->first()->qty - $cart[$i]['count'];
			  
				$warehouse_data->update([
					'qty' => $warehouse_count
				]);

				$product->update([
					'qty' => $product_quantity
				]);

				$product_variant_data = DB::table('product_variants')->select('id', 'variant_id', 'qty')
					->where('product_id', $product->id)->where('id', $cart[$i]['size_id']);

				//deduct product variant quantity if exist
				if($product_variant_data->first()) {
					$variant_count = $product_variant_data->first()->qty - $cart[$i]['count'];
					$product_variant_data->update([
						'qty' => $variant_count
					]);
				}

			}
        
        if ($couponCart = $request->couponCart) {
            $coupon = Coupon::where('code', $couponCart)->first();
            $coupon->used += 1;
            $coupon->save();
        }
		

        switch ($request->payment_method){
            case 'cod':
                $order->update([
                   'type' => 'cod'
                ]);
                return response()->json(['msg' => 'Order placed successfully!'], 200);
                break;
            case 'ssl':
                $order->update([
                    'type' => 'ssl'
                ]);
                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');
                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
                break;
            default:
                return response()->json(['msg' => 'An error occurred while processing your order!'], 404);
        }
    }


    public function index(Request $request){

        if (!session()->has('cart')) {
            return redirect('/');
        }
        $customer = auth('customer')->user();
        $total = session()->get('cart_total');
        $cart = session()->get('cart');
		$cart = array_values($cart);
        $count = count($cart) ?? [];
		
        if ($count <= 0 || $total <= 0) {
            session()->put('payment_message', 'An error occurred while processing your order!');

            session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
            return view('frontend.payment');
        }

        if ($request->payment_method != 'ssl' && $request->payment_method != 'cod') {
            session()->put('payment_message', 'An error occurred while processing your order!');
           session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
            return view('frontend.payment');
        }

        if ($request->shipping_address) {
            $request->validate([
               'shipping_address' => 'required',
               'shipping_city' => 'required',
               'shipping_district' => 'required',
               'shipping_state' => 'required',
               'shipping_postal_code' => 'required',
            ]);
        }

        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

        ]);

        $notes = $request->notes;



        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  $request->name ?? "";
        $post_data['cus_email'] =  $request->email ?? "";
        $post_data['cus_add1'] = $request->address ?? "";
        $post_data['cus_add2'] = $request->address ?? "";
        $post_data['cus_city'] =  $request->city ?? "";
        $post_data['cus_state'] = $request->state ?? "";
        $post_data['cus_postcode'] = $request->postal_code ?? "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] =  $request->phone_number ?? "";;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] =  $request->shipping_name ?? $request->name;
        $post_data['ship_add1'] =  $request->shipping_address ?? $request->address;
        $post_data['ship_add2'] = $request->shipping_address ?? $request->address;
        $post_data['ship_city'] = $request->shipping_city ?? $request->city;
        $post_data['ship_district'] = $request->shipping_district ?? $request->district;
        $post_data['ship_state'] = $request->shipping_state ?? $request->state;
        $post_data['ship_postcode'] = $request->shipping_postal_code ?? $request->postal_code;
        $post_data['ship_phone'] = $request->shipping_phone_number ?? $request->phone_number;
        $post_data['ship_email'] = $request->shipping_email ?? $request->email;
        $post_data['ship_country'] = "Bangladesh";



        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Mridha Enterprise";
        $post_data['product_category'] = "Mridha Enterprise";
        $post_data['product_profile'] = "Mridha Enterprise";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";



        $shipping_cost = session()->get('shipping_cost')??null;
        $sub_total     = session()->get('sub_total')??null;
        
        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'city' => $post_data['cus_city'],
                'district' => $post_data['ship_district'],
                'state' => $post_data['cus_state'],
                'postal_code' => $post_data['cus_postcode'],
                'country' => 'Bangladesh',
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'customer_id' => $customer->id,
                'origin' => 'Website',
                'notes' => $notes,


                'shipping_name'       => $post_data['ship_name'],
                'shipping_state'      => $post_data['ship_state'],
                'shipping_district'   => $post_data['ship_district'],
                'shipping_city'       => $post_data['ship_city'],
                'shipping_postal_code'=> $post_data['ship_postcode'],
                'shipping_address'    => $post_data['ship_add1'],
                'shipping_phone_number'=> $post_data['ship_phone'],
                'shipping_email'      => $post_data['ship_email'],

                'shipping_cost'      => $shipping_cost,
                'sub_total'          => $sub_total,
                



                'created_at' => now(),
            ]);

        $order = Order::where('transaction_id', $post_data['tran_id'])->first();
		
        for ($i = 0; $i < $count; $i++) {
            OrderDetails::create([
                'order_id'   => $order->id,
                'product_id' => $cart[$i]['product_id'],
                'count'      => $cart[$i]['count'],
                'color_id'   => $cart[$i]['color_id'],
                'size_id'    => $cart[$i]['size_id'],
                'weight_id'  => $cart[$i]['weight_id'],
                'type_id'    => $cart[$i]['type_id'],
				'amount'    => $post_data['total_amount']
            ]);
			

            $warehouse = DB::table('product_warehouse')->where('product_id', $cart[$i]['product_id'])->first();
            $product = Product::find($cart[$i]['product_id']);
            $warehouse_data = DB::table('product_warehouse')->where([
                ['product_id', $product->id],
                ['warehouse_id', $warehouse->warehouse_id],
            ]);

            $product_quantity = $product->qty - $cart[$i]['count'];
            $warehouse_count = $warehouse_data->first()->qty - $cart[$i]['count'];
          
            $warehouse_data->update([
                'qty' => $warehouse_count
            ]);

            $product->update([
                'qty' => $product_quantity
            ]);
			
			
			if($cart[$i]['size_id']){
				$product_variant_data = DB::table('product_variants')->select('id', 'variant_id', 'qty')
                ->where('product_id', $product->id)->where('id', $cart[$i]['size_id']);
			}elseif($cart[$i]['weight_id']){
				$product_variant_data = DB::table('product_variants')->select('id', 'variant_id', 'qty')
                ->where('product_id', $product->id)->where('id', $cart[$i]['weight_id']);
			}elseif($cart[$i]['color_id']){
				$product_variant_data = DB::table('product_variants')->select('id', 'variant_id', 'qty')
                ->where('product_id', $product->id)->where('id', $cart[$i]['color_id']);
			}
            

            //deduct product variant quantity if exist
            if($product_variant_data->first()) {
                $variant_count = $product_variant_data->first()->qty - $cart[$i]['count'];
                $product_variant_data->update([
                    'qty' => $variant_count
                ]);
            }

        }

        if (session()->has('couponCart')) {
            $couponCart = session()->get('couponCart');
            $coupon = Coupon::where('code', $couponCart['code'])->first();
            $coupon->used += 1;
            $coupon->save();
        }


        switch ($request->payment_method){
            case 'cod':
                $order->update([
                   'type' => 'cod'
                ]);
                //Send order confirmation email

                $order_info       = DB::table('orders')->where('transaction_id', $post_data['tran_id'])->first();

				//Send SMS Confirmation
				if($order_info->phone){
					$mobileNumber = $order_info->phone;
					$message = 'Thank you for your order. Transaction ID #'.$post_data['tran_id'].' Vist azoka.com.bd/customer-login for further details.';
					sendSms($mobileNumber,$message);
				}

				//Send Email Confirmation
				$data = [];
                $data['order_id']     = $order_info->id;
                $data['shipping_cost']= $order_info->shipping_cost;
                $data['sub_total']   = $order_info->sub_total;

                $data['user_name']  = $order_info->name;
                $data['user_email'] = $order_info->email;
                $data['user_phone'] = $order_info->phone;
                $data['amount']     = $order_info->amount;
                $data['state']      = $order_info->state;
                $data['district']   = $order_info->district;
                $data['postal_code']= $order_info->postal_code;
                $data['address']    = $order_info->address;
                $data['currency']   = $order_info->currency;
                $data['created_at'] = $order_info->created_at;
                $data['tran_id']    =  $post_data['tran_id'];
                $recipient          = $order_info->email;
                $message = view('email.order',array('data'=> $data));
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.'AZOKA'.' <info@azoka.com.bd>' . "\r\n";
                $send = mail($recipient, 'Thank You For Your Order.', $message, $headers);
                session()->put('payment_message', 'Order placed successfully!');
                session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
				
				
				
                return view('frontend.payment');
                break;
            case 'ssl':
                $order->update([
                    'type' => 'ssl'
                ]);


                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
                break;
            default:
                session()->put('payment_message', 'An error occurred while processing your order!');
                session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total', 'cart_items_quantity']);
                return view('frontend.payment');
        }


    }

    
    public function pay_again(Request $request){

        $transaction_id = $request->transaction_id;
        $order = Order::where('transaction_id', $transaction_id)->first();
        $new_transaction_id = uniqid();

        if(!$order){
            session()->put('payment_message', 'An error occurred while processing your order! Please make a new order!');
            return back();
        }

        $post_data = array();
        $post_data['total_amount'] = $order->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $transaction_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  $order->name ?? "";
        $post_data['cus_email'] =  $order->email ?? "";
        $post_data['cus_add1'] = $order->address ?? "";
        $post_data['cus_add2'] = $order->address ?? "";
        $post_data['cus_city'] =  $order->city ?? "";
        $post_data['cus_state'] = $order->state ?? "";
        $post_data['cus_postcode'] = $order->postal_code ?? "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] =  $order->phone ?? "";;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] =  $order->shipping_name ?? $order->name;
        $post_data['ship_add1'] =  $order->shipping_address ?? $order->address;
        $post_data['ship_add2'] = $order->shipping_address ?? $order->address;
        $post_data['ship_city'] = $order->shipping_city ?? $order->city;
        $post_data['ship_district'] = $order->shipping_district ?? $order->district;
        $post_data['ship_state'] = $order->shipping_state ?? $order->state;
        $post_data['ship_postcode'] = $order->shipping_postal_code ?? $order->postal_code;
        $post_data['ship_phone'] = $order->shipping_phone_number ?? $order->phone;
        $post_data['ship_email'] = $order->shipping_email ?? $order->email;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Mridha Enterprise";
        $post_data['product_category'] = "Mridha Enterprise";
        $post_data['product_profile'] = "Mridha Enterprise";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $shipping_cost = $order->shipping_cost ?? null;
        $sub_total     = $order->sub_total ?? null;
        
        switch ($order->type){

            case 'ssl':
                $order->update([
                    'type' => 'ssl'
                ]);


                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
                break;
            default:
                session()->put('payment_message', 'An error occurred while processing your order!');
                return view('frontend.payment');
        }

    }

    

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "AmarShop";
        $post_data['product_category'] = "AmarShop";
        $post_data['product_profile'] = "AmarShop";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request){

        $tran_id = $request->input('tran_id');
        $amount  = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending' || $order_detials->status == 'Failed') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

               $payment_message = session()->get('payment_message') . "\nTransaction is successfully Completed";
               session()->put('payment_message', $payment_message);
                // echo "<br >Transaction is successfully Completed";
                $order_info       = DB::table('orders')->where('transaction_id', $tran_id)->first();


				//Send SMS Confirmation
				if($order_info->phone){
					$mobileNumber = $order_info->phone;
					$message = 'Thank you for your order. Transaction ID #'.$tran_id.' Vist azoka.com.bd/customer-login for further details.';
					sendSms($mobileNumber,$message);
				}

				
				//Send Email Confirmation
                $data = [];
                $data['order_id']   = $order_info->id;
                $data['shipping_cost']= $order_info->shipping_cost;
                $data['sub_total']   = $order_info->sub_total;
                $data['user_name']  = $order_info->name;
                $data['user_email'] = $order_info->email;
                $data['user_phone'] = $order_info->phone;
                $data['amount']     = $order_info->amount;
                $data['state']      = $order_info->state;
                $data['district']   = $order_info->district;
                $data['postal_code']= $order_info->postal_code;
                $data['address']    = $order_info->address;
                $data['currency']   = $order_info->currency;
                $data['created_at'] = $order_info->created_at;
                $data['tran_id']    =  $tran_id;
                $recipient = $order_info->email;
                $message = view('email.order',array('data'=> $data));
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.'AZOKA'.' <info@azoka.com.bd>' . "\r\n";
                mail($recipient, 'Thank You For Your Order.', $message, $headers);
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                session()->put('payment_message', 'Validation Fail');
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */

            $payment_message = session()->get('payment_message') . "\nTransaction is successfully Completed";
            session()->put('payment_message', $payment_message);

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            session()->put('payment_message', 'Invalid Transaction');
        }

        return view('frontend.payment');


    }

    public function fail(Request $request){
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending' || $order_details->status == 'Failed') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
