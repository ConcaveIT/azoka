<?php

namespace App\Http\Controllers;

use App\FeaturedProduct;
use App\Product;
use Illuminate\Http\Request;

class FeaturedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        //
        $featureds = FeaturedProduct::latest()->get();
        $products = Product::latest()->get();

        return view('pages.featured', compact('featureds', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $product = Product::findOrFail($request->product_id);

        FeaturedProduct::create([
            'product_id' => $product->id,
            'category_id' => $product->category_id
        ]);

        return redirect(route('featured.index'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $featuredProduct = FeaturedProduct::findOrFail($id);

        $featuredProduct->delete();

        return redirect(route('featured.index'));
    }
}
