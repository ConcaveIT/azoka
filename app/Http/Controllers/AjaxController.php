<?php

namespace App\Http\Controllers;

use App\AmarCare;
use App\Brand;
use App\Category;
use App\Color;
use App\Coupon;
use App\FeaturedProduct;
use App\Product;
use App\Sale;
use App\Size;
use App\Slider;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class AjaxController extends Controller
{
    //
    public function add_wishlist(Request $request){
        $customer = Auth::guard('customer')->id();
        if($customer){
            Wishlist::firstOrCreate([
                'customer_id' => Auth::guard('customer')->id(),
                'product_id' => $request->productId
             ]);
        }else{
            return 0;
        }

        $wistlist_count = auth()->guard('customer')->user()->wishlist->count();
        // return Wishlist::all()->count();
        return  $wistlist_count;
    }

    public function add_compare(Request $request)
    {

        $compare = session()->get('compare');

        if (!$compare || count($compare) < 3) {

            $compare[] = $request->productId;

            session()->put('compare', $compare);

            $compare = session()->get('compare');
        }

        return count($compare);

    }

    public function remove_wishlist($wishId)
    {
        Wishlist::findOrFail($wishId)->delete();

        return redirect(route('wishlist'));
    }









    
    public function add_cart(Request $request) {
        // var_dump($request->color_id);
        // var_dump($request->size_id);
        // var_dump($request->type_id);
        // exit;
        $cart = session()->get('cart');
        $cart_sub_total = session()->get('cart_sub_total') ??  0;
        $cart_weight = session()->get('cart_weight') ??  0;

        $cart[] = array(
            'cart_id' => uniqid(),
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'type_id' => $request->type_id,
            'weight_id' => $request->weight_id,
            'count' => $request->count,
        );
        $product = Product::find($request->product_id);
        $product_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date);
        $product_variation = DB::table('product_variants')->whereIn('id', [$request->color_id, $request->size_id, $request->type_id, $request->weight_id])->get();


       
        foreach ($product_variation as $variation) {
            $product_price += $variation->additional_price;
            $cart_weight += intval($variation->item_code);
        }
        $product_price *= $request->count;
        $cart_sub_total += $product_price;

        session()->put('cart_sub_total', $cart_sub_total);
        session()->put('cart_items_count', count($cart));

        $cart_items_quantity = 0;
        foreach ($cart as $data) {
            $cart_items_quantity += $data['count'];

        }

        session()->put('cart_items_quantity', $cart_items_quantity);
        session()->put('cart_weight', $cart_weight);
        session()->put('cart', $cart);

        
        return response()->json([
            'cart_items_quantity' => $cart_items_quantity,
            'cart_sub_total' => $cart_sub_total,
        ]);
    }













    public function update_cart(Request $request){


        foreach(session()->get('cart') ?? [] as $data){
            $product = \App\Product::findOrFail($data['product_id']);
            $color = DB::table('product_variants')->find($data['color_id']);
            $size = DB::table('product_variants')->find($data['size_id']);
            $type = DB::table('product_variants')->find($data['type_id']);
            $weight = DB::table('product_variants')->find($data['weight_id']);
        }

        $cart = session()->pull('cart');
        $cart_sub_total = 0;
        $cart_weight = session()->pull('cart_weight') ?? 0;
        $newCart = [];

        if ($cart) {
            foreach ($cart as $i => $data) {
                $product = Product::findOrFail($data['product_id']);

                if ($request->count[$i] > $product->qty) {
                    $data['count'] = $product->qty;
                    session()->put('msg', 'Product quantity exceeded and set to maximum');
                } else {
                    $data['count'] = $request->count[$i];
                }
                $newCart[] = $data;
            // var_dump($request->size_id[$i]);
            // exit;
                $product_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0);
                // $product_variation = DB::table('product_variants')->where('id', $request->size_id[$i])->get();
                // foreach ($product_variation as $variation) {
                //     $product_price += $variation->additional_price;
                //     $cart_weight += intval($variation->item_code);
                // }
                $product_price *= $data['count'];
                $cart_sub_total += $product_price;
            }
        }

        session()->forget('cart');
        session()->put('cart', $newCart);
        session()->put('cart_sub_total', $cart_sub_total);
        session()->put('cart_items_count', count($newCart));

        $cart_items_quantity = 0;

        foreach ($newCart as $data) {
            $cart_items_quantity += $data['count'];
        }

        session()->put('cart_items_quantity', $cart_items_quantity);
        session()->put('cart_weight', $cart_weight);



        return redirect('/cart');
    }









    public function remove_cart($cartId){
        foreach(session()->get('cart') ?? [] as $data){
            $product = \App\Product::findOrFail($data['product_id']);
            $color = DB::table('product_variants')->find($data['color_id']);
            $size = DB::table('product_variants')->find($data['size_id']);
            $type = DB::table('product_variants')->find($data['type_id']);
            $weight = DB::table('product_variants')->find($data['weight_id']);
        }
        $cart = session()->get('cart');
        $cart_sub_total = session()->get('cart_sub_total') ??  0;
        foreach ($cart as $i => $data) {
            if ($data['cart_id'] == $cartId) {
                $product = Product::findOrFail($data['product_id']);
                //$product_price = $product->discount ? $product->price - round($product->price * $product->discount / 100) : $product->price;
                $product_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0);
                $product_price *= $data['count'];

                // var_dump($product_price);
                // exit;
                $cart_sub_total -= $product_price;
                session()->put('cart_sub_total', $cart_sub_total);
                unset($cart[$i]);
            }
        }
        session()->put('cart_items_count', count($cart));
        $cart_items_quantity = 0;
        foreach ($cart as $data) {
            $cart_items_quantity += $data['count'];
        }
        session()->put('cart_items_quantity', $cart_items_quantity);
        session()->put('cart', $cart);
        return redirect('/cart');
    }

    public function headercart($cartId){
        foreach(session()->get('cart') ?? [] as $data){
            $product = \App\Product::findOrFail($data['product_id']);
            $color = DB::table('product_variants')->find($data['color_id']);
            $size = DB::table('product_variants')->find($data['size_id']);
            $type = DB::table('product_variants')->find($data['type_id']);
            $weight = DB::table('product_variants')->find($data['weight_id']);
        }
        $cart = session()->get('cart');
        $cart_sub_total = session()->get('cart_sub_total') ??  0;
        foreach ($cart as $i => $data) {
            if ($data['cart_id'] == $cartId) {
                $product = Product::findOrFail($data['product_id']);
                //$product_price = $product->discount ? $product->price - round($product->price * $product->discount / 100) : $product->price;
                $product_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0);
                $product_price *= $data['count'];

                // var_dump($product_price);
                // exit;
                $cart_sub_total -= $product_price;
                session()->put('cart_sub_total', $cart_sub_total);
                unset($cart[$i]);
            }
        }
        session()->put('cart_items_count', count($cart));
        $cart_items_quantity = 0;
        foreach ($cart as $data) {
            $cart_items_quantity += $data['count'];
        }
        session()->put('cart_items_quantity', $cart_items_quantity);
        session()->put('cart', $cart);
        return 1;
    }
    


    







    public function loadModal($id)
    {
        $product = Product::findOrFail($id);
        $product_variant = $product->variant->groupBy('name');

        return view('frontend.layout.modal_body',['data'=>$product, 'product_variant'=>$product_variant]);
    }

    public function loadModalReview($id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.layout.modal_review',['data'=>$product]);
    }



    public function apply_coupon(Request $request){
        $coupon = Coupon::where('code', $request->coupon)->first();
        $cart_sub_total = session()->get('cart_sub_total');
        if (!$coupon) {
            return redirect()->back()->with('message', 'Invalid Coupon');
        }
        else {
            if ($coupon->expired_date <= Carbon::now()) {
                return redirect()->back()->with('message', 'Coupon Expired!');
            }
            if ($coupon->minimum_amount > $cart_sub_total) {
                return redirect()->back()->with('message', 'Minimum amount for this coupon is not reached!');
            }
            if ($coupon->user_id != \auth('customer')->id()) {
                return redirect()->back()->with('message', 'You are not eligible for this coupon!');
            }
            if ($coupon->quantity <= $coupon->used) {
                return redirect()->back()->with('message', 'You have used all of your coupons!');
            }
            else {
                switch ($coupon->type) {
                    case 'fixed':
                        $coupon_value = $coupon->amount;
                        break;
                    case 'percentage':
                        $coupon_value = ($cart_sub_total * $coupon->amount) / 100;
                }
                $couponCart = [
                  'code' => $coupon->code,
                  'value' => $coupon_value,
                ];
                session()->put('couponCart', $couponCart);
                return redirect(route('cart'));
            }
        }
    }

    public function remove_coupon(){
        session()->forget('couponCart');

        return redirect(route('cart'));
    }


    public function filter_product(Request $request){
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;

        $minPrice = (int)$request->min_amount;
        $maxPrice = (int)$request->max_amount;
        $data = Product::whereBetween('price', [$minPrice, $maxPrice])->where('is_active', 1);

        if ($category_id != -1) {
            $data->where('category_id', $category_id);
        }
        if ($brand_id != -1) {
            $data->where('brand_id', $brand_id);
        }

        $data = $data->get();

        return view('frontend.choose-product', compact('data'))->render();
    }




    public function filter_product_shop(Request $request) {
        if($request->brand_id){
            $brand = $request->brand_id;
        }else{
            $brand = null;
        }

        $category_id = $request->category_id;
        $brand_id = $request->brand_id;

        $minPrice = (int)$request->min_amount;
        $maxPrice = (int)$request->max_amount;
        $data = Product::whereBetween('price', [$minPrice, $maxPrice])->where('is_active', 1);

        $data->where('category_id', $category_id);
  
        if ($brand_id != -1) {
            $data->where('brand_id', $brand_id);
        }

        $data = $data->get();

        return view('frontend.choose-product', compact('data'))->render();

    }












    public function filter_product_subshop(Request $request)
    {
        $brand = $request->brand_id;
        $size = $request->size_id;

        $minPrice = $request->min_amount;
        $maxPrice = $request->max_amount;

        $data = Product::whereBetween('price', [$minPrice, $maxPrice]);

        $data->where('sub_category_id', $request->sub_category_id);


        if ($brand != -1) {
            $prodIds = Brand::find($brand)->products()->pluck('id');
            $data->whereIn('id', $prodIds);
        }

        if ($size != -1) {

            $prodIds = Size::find($size)->products()->pluck('id');
            $data->whereIn('id', $prodIds);
        }

        $data = $data->get();


        return view('frontend.choose-product', compact('data'))->render();

    }

    public function rate_product(Request $request){
        $product = Product::findOrFail($request->product_id);
        $star = $request->star;
        $comment = $request->comment;
        $customer = \auth('customer')->user();
        if(!$customer){
            return redirect(url('/customer-login'));
        }

        if(!$star){
            Session::flash('error', 'Star rating field is required.'); 
            return redirect()->back();
        }
        if(!$comment){
            Session::flash('error', 'Comment field is required.'); 
            return redirect()->back();
        }
        $customer->comment($product, $comment, $star);
        return redirect()->back();
    }

    public function comment_vlog(Request $request)
    {

        $vlog = AmarCare::findOrFail($request->vlog_id);
        $comment = $request->comment;
        $customer = \auth('customer')->user();



        $customer->comment($vlog, $comment, $rate=0);

        return redirect()->back();

    }

    public function product_price(Request $request)
    {
        $data = DB::table('product_size')
            ->where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)
            ->first();

        $product = Product::with('sale')->findOrFail($request->product_id);

        return response()->json([
            'data' => $data,
            'product' => $product
        ]);

    }

}
