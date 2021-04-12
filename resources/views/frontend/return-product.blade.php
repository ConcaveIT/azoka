@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Return Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <h1 class="text-center text-5xl mb-5">Why are you returning this order?</h1>
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                <tr>
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

                                @forelse($order->order_details as $data)
                                    <tr>
                                    <td><img width="100px" src="{{ asset($data->product->image_primary) }}" alt=""></td>
                                    <td>{{ $data->product->name }}</td>
                                    <td><span class="py-2 px-4" style="background-color: {{ $data->color->name }}"></span></td>
                                    <td>{{ $data->size->name }}</td>
                                    <td>BDT {{ $price = $data->product->discount ? $data->product->price - round($data->product->price * $data->product->discount / 100) : $data->product->price }}</td>
                                    <td>{{ $data->count }}</td>
                                    <td>{{ $data->count * $price }}</td>
                                    </tr>
                                @empty
                                @endforelse



                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="col-6 text-xl mb-5">
                    <p>Total Products: {{ $order->order_details->sum('count') }}</p>
                    <p>Total Amount: {{ $order->amount }}</p>
                </div>

            </div>



            <form action="{{ route('return-product', $order->id) }}" method="POST">
                @csrf
                <div class="flex flex-col justify-center">
                    <label class="text-xl" for="return_reason">Returning Reason: </label>
                    <textarea class="border" name="returning_reason" id="returning_reason" cols="100" rows="10"></textarea>
                </div>

                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="mt-4">
                    <button class="customButton p-2">Submit Request</button>
                </div>


            </form>

        </div>
    </section>
    <!-- my account end   -->

     <!--brand area start-->
@include('frontend.layout.brand')
    <!--brand area end-->

@endsection


@section('modal')

    @include('frontend.layout.modal')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection
