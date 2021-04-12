<?php

namespace App\Http\Controllers;

use App\AmarCare;
use App\Brand;
use App\Category;
use App\Deal;
use App\FeaturedProduct;
use App\Order;
use App\Page;
use App\Product;
use App\ReturnProduct;
use App\Sale;
use App\Slider;
use App\SubCategory;
use App\Tag;
use App\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    //
    public function index(){
        $featuredProdIds = Product::where('featured', 1)->pluck('id');
        $featuredCatIds = Product::where('featured', 1)->pluck('category_id');
        $featuredCategories = Category::whereIn('id', $featuredCatIds)->get();


        $sliders = Slider::latest()->get();
        $categories = Category::where('is_active', 1)->get();

        $newProducts = Product::whereDate('created_at', Carbon::now()->subDays(7))->where('is_active', 1)->get();

        if ($newProducts->count() <= 0) {
            $newProducts = Product::latest()->where('is_active', 1)->limit(20)->get();
        }

        $allProducts = Product::where('is_active', 1)->get();

        $brands = Brand::all();
        return view('frontend.index', compact(
            'categories', 'featuredCategories', 'featuredProdIds',
            'newProducts', 'sliders', 'allProducts'
        ));
    }

    public function shop($slug)
    {
        $shop = Category::where('slug', $slug)->first();
        $categories = Category::all();
        $data = $shop->products()->paginate(9);

        return view('frontend.shop', compact('categories', 'data', 'shop'));
    }

    public function subshop($shopId, $subId)
    {
        $shop = Category::findOrFail($shopId);
        $subshop = SubCategory::findOrFail($subId);
        $categories = Category::all();
        $data = $subshop->products()->paginate(9);


        return view('frontend.subshop', compact('subshop', 'shop', 'data'));
    }

    public function product_details($shopSlug, $productSlug){
        $category = Category::where('slug', $shopSlug)->first();
        $product = Product::with('variant')->where('is_active', 1)->where('category_id', $category->id)->where('slug', $productSlug)->first();
        
        if(!$product){
            return redirect('/');  
        }

        $related_products = Product::where('category_id', $category->id)->where('is_active', 1)->limit(20)->get();
        // var_dump($related_products);
        // exit;
        $brands = Brand::all();


        $product_variant = $product->variant->groupBy('name');

 


        $product_variants = DB::table('product_variants')->where('product_id', $product->id)->orderBy('variant_id')->get();

        return view('frontend.product-details',
            compact('category', 'product', 'related_products', 'brands', 'product_variant', 'product_variants'));
    }

    public function wishlist()
    {
        $customer = Auth::guard('customer')->user();
        $wishlist = $customer->wishlist ?? [];
        $brands = Brand::all();
        return view('frontend.wishlist', compact('brands', 'wishlist'));
    }

    public function cart()
    {


        $cart = \session()->get('cart') ?? [];

        $brands = Brand::all();


        return view('frontend.cart', compact('cart', 'brands'));
    }

    public function checkout()
    {
        $brands = Brand::all();
        $cart = \session()->get('cart');

        return view('frontend.checkout', compact('brands', 'cart'));
    }

    public function my_account()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $customer = \auth('customer')->user();

        return view('frontend.my-account', compact('categories', 'brands', 'customer'));
    }

    
    public function update_account(Request $request)
    {

        $customer = \auth('customer')->user();

        $data = $request->validate([
            'email' => 'unique:customers,email,'.$customer->id,
            'password' => 'required|min:6',
        ]);

        $receive_offer = $request->receive_offer ? true : false;
        $newsletter = $request->newsletter ? true : false;

        $customer->update([
            'name' => $request->name,
            'email' =>$data['email'],
            'phone_number' => $request->phone_number,
            'password' => bcrypt($data['password']),
            'birthdate' => $request->birthdate,
            'receive_offer' => $receive_offer,
            'newsletter' => $newsletter,

        ]);

        return redirect(route('my-account'));
    }

    public function update_address(Request $request)
    {

        $customer = \auth('customer')->user();

        $customer->update([
            'country' => 'bangladesh',
            'state' => $request->state,
            'district' => $request->district,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
        ]);

        return redirect(route('my-account'));
    }

    public function contact()
    {
        $brands = Brand::all();
        return view('frontend.contact', compact('brands'));
    }

    public function about(){
        $brands = Brand::all();
        return view('frontend.about', compact('brands', 'page'));
    }

    public function amar_care($catId)
    {
        $vlogs = AmarCare::where('category_id', $catId)->latest()->get();

        return view('pages.amar-care', compact('vlogs'));
    }

    public function vlog($catId, $vlogId)
    {
        $vlog = AmarCare::findOrFail($vlogId);

        return view('pages.vlog', compact('vlog'));
    }

    public function compare()
    {
        $compare = \session()->get('compare');


        return view('frontend.compare', compact('compare'));
    }

    public function tag_search($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();

        return view('frontend.tag-search', compact('tag'));
    }

    public function brand_search($brandName)
    {
        $prodIds = Brand::where('title', $brandName)->first()->products()->pluck('id');


        $products = Product::whereIn('id', $prodIds)->get();

        return view('frontend.brand-search', compact('brandName', 'products'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $products = Product::where('name', 'LIKE', '%'.$search.'%')->where('is_active', 1)->get();

        return view('frontend.search', compact('products', 'search'));
    }

    public function return_product($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('frontend.return-product', compact('order'));
    }

    public function return_request(Request $request)
    {
        ReturnProduct::create([
           'customer_id' => \auth('customer')->id(),
           'order_id' => $request->order_id,
           'returning_reason' => $request->returning_reason,
        ]);

        return redirect(route('my-account'));
    }

    public function password_reset()
    {
        return view('frontend.password-reset');
    }
}
