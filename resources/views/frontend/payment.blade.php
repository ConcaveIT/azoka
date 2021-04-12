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
                            <li>Payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->


    <!--Checkout page section-->
    <div class="Checkout_section">
       <div class="container text-center text-2xl">
           <h1>{!! nl2br(e(session()->get('payment_message'))) !!}</h1>
           <h1>Thank you for shopping with us.</h1>

        </div>
    </div>
    <!--Checkout page section end-->

    <!--brand area start-->
    @include('frontend.layout.brand')
    <!--brand area end-->

@endsection


@section('footer')

    @include('frontend.layout.footer')

@endsection
