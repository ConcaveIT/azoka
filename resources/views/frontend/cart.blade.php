

@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')
<style>
.continue_shopping{
background: #9A5826;
border:0;
border:1px solid #9A5826;
}
.continue_shopping:hover{
background: #873a00;
border:0;
border:1px solid #873a00;
}   
</style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Shopping Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

     <!--shopping cart area start -->
    @if(session()->get('cart_items_quantity') > 0)
    <div class="shopping_cart_area">
        <div class="container">
            <form action="/cart/update" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            {{-- @php
                                 var_dump(session()->all());
                            @endphp --}}
                            <div class="cart_page table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product_remove">Delete</th>
                                    <th class="product_thumb">Image</th>
                                    <th class="product_name">Product</th>
                                    <th class="product_name">Color</th>
                                    <th class="product_name">Size</th>
                                    <th class="product-price">Price</th>
                                    <th class="product_quantity">Quantity</th>
                                    <th class="product_total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php

                                $sub_total = 0;

                                $shipping_cost = 0;

                            @endphp

                            @forelse(session()->get('cart') ?? [] as $data)

                                @php
                                    $product = \App\Product::findOrFail($data['product_id']);
                                    $color = DB::table('product_variants')->find($data['color_id']);
                                    $size = DB::table('product_variants')->find($data['size_id']);
                                    $type = DB::table('product_variants')->find($data['type_id']);
                                    $weight = DB::table('product_variants')->find($data['weight_id']);
                                @endphp

                                <tr>
                                   <td class="product_remove"><a href="/cart/remove/{{ $data['cart_id'] }}"><i class="fa fa-trash-o"></i></a></td>
                                    <td class="product_thumb"><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}"><img src="{{ productImage($product->image) }}" alt=""></a></td>
                                    <td class="product_name"><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">{{ $product->name }}</a></td>
                                    <td class="product-price">{{ $color ? $color->item_code : '' }}</td>
                                    <td class="product-price">{{ $size ? $size->item_code : '' }}</td>

                                    <td class="product-price">BDT 
                                         {{ $cart_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0) }}
                                        
                                    </td>
                                    <td class="product_quantity"><label>Quantity</label> <input min="1" max="10000" name="count[]" value="{{ $data['count'] }}" type="number"></td>
                                    
                                    
                                    <td class="product_total">BDT {!! $row_total = $cart_price * $data['count'] !!}</td>

                                    @php
                                        $sub_total += $row_total;
                                        session()->put('sub_total', $sub_total);
                                    @endphp


                                </tr>
                            @empty
                            @endforelse

                            </tbody>
                        </table>
                            </div>
                            <div class="cart_submit">
                                <button type="submit">update cart</button>
                            </div>
                        </div>
                     </div>
                    @if(session()->has('msg'))
                    <p class="w-full text-right text-danger font-bold">{{ session()->get('msg') }}</p>
                    @endif
                 </div>
            </form>
                 <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <h3 class="">Coupon</h3>
                                <div class="coupon_inner">
                                    <p>Enter your coupon code if you have one.</p>
                                    <form action="{{ route('apply-coupon') }}" method="POST">
                                        @csrf
                                    <input placeholder="Coupon Code" type="text" name="coupon">
                                    <button type="submit">Apply coupon</button>
                                    </form>
                                </div>
                            </div>

                            <span class="text-danger">{{ session('message') }}</span>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right">
                                <h3>Cart Calculations</h3>
                                <div class="coupon_inner">
                                   <div class="cart_subtotal">
                                       <p>Subtotal</p>
                                       <p class="cart_amount" id="cart_sub_total">BDT {{ $sub_total }}</p>
                                   </div>


                                    @if(session()->has('couponCart'))
                                        @php $couponCart = session()->get('couponCart'); @endphp
                                        <div class="cart_subtotal">
                                            <p>Discount</p>
                                            <p class="flex">({{ $couponCart['code'] }})<a title="Remove" href="{{ route('remove-coupon') }}"><i class="fa fa-remove"></i></a></p>
                                            <p class="cart_amount" id="">BDT {{ $discount = $couponCart['value'] }}</p>
                                        </div>


                                    @endif

                                    <div class="cart_subtotal ">
                                        <p>Shipping</p>
                                        <p id="shippingCost" class="cart_amount">BDT 0</p>
                                    </div>

                                    <div>

                                        <div class="flex items-center">

                                            <input type="radio" class="location" name="location" value="inside_dhaka" required> Inside Dhaka


                                            <input type="radio" class="ml-5 location" name="location" value="outside_dhaka" required> Outside Dhaka

                                        </div>

                                        <p> * Please choose correctly, otherwise delivery won't be guaranteed.</p>

                                    </div>

                                   <div class="checkout_btn">
                                       <a onclick="return checkLocation();" href="{{ route('checkout') }}">Proceed to Checkout</a>
                                       <p> * Cart total will be calculated accordingly.</p>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->

        </div>
    </div>
    @else 
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3 mb-5">
                    <h1 style="font-size: 20px;font-weight: 600;">Your cart is empty.</h1>
                    <br>
                    <a href="{{url('/')}}"> <button class="btn btn-info continue_shopping">Continue Shopping</button> </a>
            </div>
        </div>
    </div>
    @endif
     <!--shopping cart area end -->



    <!--brand area start-->
    @include('frontend.layout.brand')
    <!--brand area end-->

@endsection

<script>
    let cart_items_quantity = @json(session()->get('cart_items_quantity'));

    let cart_weight = @json(session()->get('cart_weight'));

    function checkLocation()
    {
        return $('input[name="location"]').is(':checked');
    }


</script>


@section('footer')

    @include('frontend.layout.footer')

@endsection

