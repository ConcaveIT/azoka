<?php

namespace App\Http\Controllers;

use App\Product;
use App\Deal ;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::orderBy('name')->where('is_active', 1)->get();
        $deals = Deal::latest()->get();

        return view('website.deals', compact('products', 'deals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($productId){
        //
        return view('website.deals', compact('productId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $deal = new Deal();

        if(empty($request->price) && empty($request->percentage)){
            $promotion_data = DB::table('products')->where('id', $request->product_id)->where('starting_date', '<=', Carbon::now())->where('last_date', '>=', Carbon::now())->where('is_active', 1)->first();
            if($promotion_data){
                $deal->price = $promotion_data->promotion_price;
            }else{
                $price_data = Product::where('id', $request->product_id)->where('is_active', 1)->first();
                if($price_data){
                    $deal->price = $price_data->price;
                }else{
                    $deal->price = null;
                }
            }
        }else{
            if($request->percentage){
                $deal->percentage = $request->percentage;
            }elseif($request->price){
                $deal->price = $request->price;
            }
        }
        $deal->expire     = $request->expire;
        $deal->product_id = $request->product_id;

        $deal->save();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param    $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deal $deal
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Deal $deal)
    {
        //
        $deal->delete();

        return redirect(route('deals.index'));
    }

    public function check_promotion($id){
        $data = DB::table('products')->where('id', $id)->where('starting_date', '<=', Carbon::now())->where('last_date', '>=', Carbon::now())->where('is_active', 1)->first();
        if($data){
            if($data->promotion_price){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }

    }

}
