<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index() {
        $orders = Order::latest()->get();
        return view('pages.orders', compact('orders'));
    }

    public function details($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('pages.order-details', compact('order'));
    }

    public function order_update(Request $request, $orderId)
    {
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
}
