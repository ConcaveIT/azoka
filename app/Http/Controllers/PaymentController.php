<?php
//
//namespace App\Http\Controllers;
//
//use App\Customer;
//use App\Order;
//use App\OrderDetails;
//use Illuminate\Http\Request;
//
//class PaymentController extends Controller
//{
//    //
//    public function index(Request $request)
//    {
//        if ($request->check_method == 'cod')
//        {
//            $this->cod($request);
//
//            session()->put('payment_message', 'Order placed successfully!');
//            session()->forget(['cart', 'cart_total', 'couponCart', 'cart_items_count', 'cart_sub_total']);
//
//            return view('frontend.payment');
//        }
//    }
//
//    public function cod($request)
//    {
//        if (auth('customer')->check()) {
//
//            $data = $request->validate([
//                'password' => 'required|confirmed',
//            ]);
//
//            $customer = auth('customer')->user();
//
//        } else {
//
//            $data = $request->validate([
//                'email' => 'email|required|unique:customers',
//                'password' => 'required|confirmed',
//            ]);
//
//            $customer = Customer::create([
//                'email' => $data['email'],
//                'password' => bcrypt($data['password'])
//            ]);
//
//        }
//
//        $total = session()->get('cart_total');
//
//
//        $order = Order::create([
//            'customer_id' => $customer->id,
//            'total' => $total,
//            'notes' => $request->notes
//        ]);
//
//
//        $billing_address = $request->street . '+';
//        $billing_address .= $request->city . '+';
//        $billing_address .= $request->district . '+';
//        $billing_address .= ucfirst($request->division);
//
//        if ($request->shipping_address) {
//            $shipping_address = $request->shipping_street . '+';
//            $shipping_address .= $request->shipping_city . '+';
//            $shipping_address .= $request->shipping_district . '+';
//            $shipping_address .= ucfirst($request->shipping_division);
//        } else {
//            $shipping_address = $billing_address;
//        }
//
//
//
//        $customer->update([
//            'name' => $request->name,
//            'phone_number' => $request->phone_number,
//            'password' => bcrypt($data['password']),
//            'billing_address' => $billing_address,
//            'shipping_address' => $shipping_address,
//
//        ]);
//
//
//        $count = session()->get('cart_items_count');
//        $cart = session()->get('cart');
//
//        for ($i = 0; $i < $count; $i++) {
//            OrderDetails::create([
//                'order_id' => $order->id,
//                'product_id' => $cart[$i]['product_id'],
//                'count' => $cart[$i]['count'],
//                'color_id' => $cart[$i]['color_id'],
//                'size_id' => $cart[$i]['size_id'],
//            ]);
//        }
//
//    }
//}
