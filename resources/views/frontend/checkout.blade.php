@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection
    <!--header area end-->

@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    @php

        $customer = auth('customer')->user();

    @endphp


{{-- @php
     var_dump(session()->all());
@endphp --}}



    <!--Checkout page section-->
    <div class="Checkout_section">
       <div class="container">

           <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
               @csrf

            <div class="checkout_form">
                <div class="row">
                    <div class="col-lg-6 col-md-6">

                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <label>Name <span>*</span></label>
                                    <input required type="text" name="name" value="{{ $customer ? $customer->name : '' }}">
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="division">Division <span>*</span></label>
                                    <select required class="select_option" name="state" id="division">
                                        <option value="{{ $customer->state ?? '' }}">{{ ucfirst($customer->state) ?? '' }}</option>
                                        <option value="dhaka">Dhaka</option>
                                        <option value="chittagong">Chittagong</option>
                                        <option value="barisal">Barisal</option>
                                        <option value="khulna">Khulna</option>
                                        <option value="mymensingh">Mymensingh</option>
                                        <option value="sylhet">Sylhet</option>
                                        <option value="rangpur">Rangpur</option>

                                    </select>
                                </div>

                                <div class="col-12 mb-20">
                                    <label>District <span>*</span></label>
                                    <input required type="text" name="district" value="{{ $customer->district ?? '' }}">
                                </div>

                                <div class="col-12 mb-20">
                                    <label>Town / City <span>*</span></label>
                                    <input required type="text" name="city" value="{{ $customer->city ?? '' }}">
                                </div>

                                <div class="col-12 mb-5">
                                    <label>Postal Code <span>*</span></label>
                                    <input type="text" name="postal_code" value="{{ $customer->postal_code ?? '' }}">
                                </div>

                                <div class="col-12 mb-20">
                                    <label> Full Shipping Address <span>*</span></label>
                                    <input required name="address" placeholder="House number and street name" value="{{ $customer->address ?? '' }}" type="text">
                                </div>

                                <div class="col-lg-6 mb-20">
                                    <label>Phone<span>*</span></label>
                                    <input required name="phone_number" type="text" value="{{ $customer ? $customer->phone_number : '' }}">

                                </div>
                                 <div class="col-lg-6 mb-20">
                                    <label> Email Address   <span>*</span></label>
                                      <input required name="email" type="email" value="{{ $customer ? $customer->email : '' }}">

                                </div>


                                <div class="col-12 mb-20">
                                    <input id="address" type="checkbox" name="shiiping_address" data-target="createp_account" />
                                    <label class="righ_0" for="address" data-toggle="collapse" data-target="#collapsetwo" aria-controls="collapseOne">Ship to a different address?</label>

                                    <div id="collapsetwo" class="collapse one" data-parent="#accordion">
                                       <div class="row">

                                           <div class="col-12 mb-20">
                                               <label>Name <span>*</span></label>
                                               <input type="text" name="shipping_name" value="{{ $customer ? $customer->name : '' }}">
                                           </div>

                                           <div class="col-12 mb-20">
                                               <label for="division">Division <span>*</span></label>
                                               <select class="select_option" name="shipping_state" id="division">
                                                   <option value="{{ $customer->state ?? '' }}">{{ $customer->state ?? '' }}</option>
                                                   <option value="dhaka">Dhaka</option>
                                                   <option value="chittagong">Chittagong</option>
                                                   <option value="barisal">Barisal</option>
                                                   <option value="khulna">Khulna</option>
                                                   <option value="mymensingh">Mymensingh</option>
                                                   <option value="sylhet">Sylhet</option>
                                                   <option value="rangpur">Rangpur</option>

                                               </select>
                                           </div>

                                           <div class="col-12 mb-20">
                                               <label>District <span>*</span>
                                               <input type="text" name="shipping_district" value="{{ $customer->district ?? '' }}">
                                               </label>
                                           </div>

                                           <div class="col-12 mb-20">
                                               <label>Town / City <span>*</span>
                                               <input type="text" name="shipping_city" value="{{ $customer->city ?? '' }}">
                                               </label>
                                           </div>

                                           <div class="col-12 mb-20">
                                               <label>Postal Code <span>*</span>
                                                   <input type="text" name="shipping_postal_code" value="{{ $customer->postal_code ?? '' }}">
                                               </label>
                                           </div>

                                           <div class="col-12 mb-20">
                                               <label> Full Shipping Address <span>*</span>
                                               <input name="shipping_address" placeholder="House number and street name" value="{{ $customer->address ?? '' }}" type="text">
                                               </label>
                                           </div>

                                           <div class="col-lg-6 mb-20">
                                               <label>Phone<span>*</span>
                                               <input name="shipping_phone_number" type="text" value="{{ $customer ? $customer->phone_number : '' }}">
                                               </label>

                                           </div>
                                           <div class="col-lg-6 mb-20">
                                               <label> Email Address   <span>*</span>
                                               <input name="shipping_email" type="email" value="{{ $customer ? $customer->email : '' }}">
                                               </label>

                                           </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-notes">
                                         <label for="order_note">Order Notes
                                        <textarea id="order_note" name="notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                         </label>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="col-lg-6 col-md-6">

                            <h3>Your order</h3>
                            <div class="order_table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($cart ?? [] as $data)
                                        @php
                                            $product = \App\Product::findOrFail($data['product_id']);
                                        @endphp
                                        {{$cart_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) }}

                                        <tr>
                                            <td> {{ $product->name }} <strong> × {{ $data['count'] }}</strong></td>
                                            <td> BDT {{ $cart_price * $data['count'] }}</td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Cart Subtotal</th>
                                            <td>BDT {{ $sub_total = session()->get('cart_sub_total') }}</td>
                                        </tr>


                                        @if(session()->has('couponCart'))
                                            @php $couponCart = session()->get('couponCart'); @endphp
                                            <tr>
                                                <th>Discount</th>
                                                <td><strong>BDT {{ $discount = $couponCart['value'] }}</strong></td>
                                            </tr>

                                            @php $sub_total -= $discount @endphp

                                        @endif


                                        <tr>
                                            <th>Shipping</th>
                                            <td id="shipping_amount">{{ $shipping_cost = session()->get('shipping_cost') }}</td>
                                        </tr>
                                        @php session()->put('cart_total', $sub_total + $shipping_cost) @endphp
                                        <tr class="order_total">
                                            <th>Order Total</th>
                                            <td><strong>BDT {{ session()->get('cart_total') }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        <input id="agree" type="checkbox"> Read and agree to our <a
                            class="text-golden" href="/terms-conditions">Terms & Conditions</a>, <a
                            class="text-golden" href="/privacy-policy">Privacy Policy</a> and <a
                            class="text-golden" href="/returns-exchange">Return & Exchange Policy</a>
                        <div class="payment_method">

                                <div class="order_button m-2">
                                    <button class="hover:text-black" id="payNowBtn" name="payment_method" value="ssl" type="submit">Pay Now</button>
                                </div>

                                <div class="order_button m-2">
                                    <button class="hover:text-black" id="codBtn" name="payment_method" value="cod" type="submit">Cash on Delivery</button>
                                </div>



                            </div>

                    </div>
                </div>
            </div>
           </form>
        </div>
    </div>
    <!--Checkout page section end-->

    <!--brand area start-->
    {{-- @include('frontend.layout.brand') --}}
    <!--brand area end-->

@endsection

@section('script')
    <script>

        $('#payNowBtn').attr('disabled', 'disabled');
        $('#codBtn').attr('disabled', 'disabled');

        $('#agree').click(function() {
            if ($(this).is(':checked')) {
                $('#payNowBtn').removeAttr('disabled');
                $('#codBtn').removeAttr('disabled');
            } else {
                $('#payNowBtn').attr('disabled', 'disabled');
                $('#codBtn').attr('disabled', 'disabled');
            }
        });
    </script>
@endsection







@section('footer')

    @include('frontend.layout.footer')

@endsection
