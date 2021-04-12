<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use PDF;


class OrderController extends Controller
{
    //
    public function index() {
        $orders = Order::latest()->get();
        return view('website.orders', compact('orders'));
    }

    public function details($orderId){
        $order = Order::findOrFail($orderId);
        return view('website.order-details', compact('order'));
    }



    
    public function invoice($orderId){
        $order = Order::findOrFail($orderId);
        $pdf = PDF::loadView('website.invoice', compact('order'));
        return $pdf->stream('invoice.pdf');
    }










    public function order_update(Request $request, $orderId){

        $order = Order::findOrFail($orderId);

        if ($request->has('payment_status')) {
            $order->update([
                'status' => 'Confirmed'
            ]);
        } else {
            $order->update([
                'status' => 'Pending'
            ]);
        }

        if ($request->has('delivery_status')) {
            $order->update([
                'delivery_status' => 'Shipped'
            ]);
        } else {
            $order->update([
                'delivery_status' => 'Awaiting'
            ]);
        }

        $order->update([
            'notes' => $request->notes,
        ]);

        return redirect()->back();

    }

    public function delete($orderId){
        $order = Order::find($orderId);
        if($order){
            Order::find($orderId)->delete();
            return back()->with('message', 'Order deleted successfully.');
        }else{
            return back()->with('not_permitted', 'Something went wrong.');
        }
    }


    public function cancel($orderId){
        $order = Order::find($orderId);
        if($order){
            $order->update([
                'status' => 'Canceled'
            ]);
            return back()->with('message', 'Order canceled successfully.');
        }else{
            return back()->with('not_permitted', 'Something went wrong.');
        }
    }


}
