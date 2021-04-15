<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetails;
use App\Product;
use Illuminate\Http\Request;
use PDF;
use DB;


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
			OrderDetails::where('order_id',$orderId)->delete();
            return back()->with('message', 'Order deleted successfully.');
        }else{
            return back()->with('not_permitted', 'Something went wrong.');
        }
    }


    public function cancel($orderId){
        $order = Order::find($orderId);
		$this->updateCanceledQty($orderId);
        if($order){
            $order->update([
                'status' => 'Canceled'
            ]);
            return back()->with('message', 'Order canceled successfully.');
        }else{
            return back()->with('not_permitted', 'Something went wrong.');
        }
    }
	
	private function updateCanceledQty($orderId){
		$OrderDetails = OrderDetails::where('order_id',$orderId)->get();
		$restored = [];
		foreach($OrderDetails as $details){
				$restored[] = [
					'product_id' => $details->product_id,
					'qty'		=> $details->count,
					'color_id' 	=>$details->color_id,
					'size_id' 	=>$details->size_id,
					'weight_id' =>$details->weight_id,
					'type_id' =>$details->type_id, 
				];
		}
		
		foreach($restored as $r){
			$product = Product::find($r['product_id']);
			$oldQty = $product->qty;
			$product->update(['qty' => ($oldQty+$r['qty'])] );
			if($product->is_variant == 1){
				$product_variation = DB::table('product_variants')->whereIn('id', [$r['color_id'], $r['size_id'], $r['type_id'], $r['weight_id']]);
				$oldVQty = $product_variation->get()[0]->qty;
				$product_variation->update(['qty' => ($oldVQty+$r['qty'])]);
			}
		} 
		
	}


}
