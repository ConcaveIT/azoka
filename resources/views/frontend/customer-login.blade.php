@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection


@section('content')
<style>
 .login_with_facebook{
    width: 200px;
 }      
@media(max-width:767px){
 .login_with_facebook{
    width: 100% !important;
    height: 55px !important;
 }   
}    
</style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Login</li>

                        </ul>

                    </div>

                </div>

                <div class="col-md-8">
                    @if(session('message'))
                        <span class="alert {{ session('alert-class') }}">{{ session('message') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="customer_login">
        <div class="container">
            <div class="row">
               <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2>login</h2>
                        <form action="customer-login" method="POST">
                            @csrf
                            <p>
                                <label>Email <span>*</span></label>
                                <input type="email" name="email">
                             </p>
                             <p>
                                <label>Password <span>*</span></label>
                                <input type="password" name="password">
                             </p>
                            <div class="login_submit">
                               <a href="{{ route('customers.showResetEmailForm', ['user_type'=>'customer']) }}">Lost your password?</a>
                                <label for="remember">
                                    <input id="remember" type="checkbox">
                                    Remember me
                                </label>
                                <button type="submit">login</button>

                            </div>
                        </form>
                     </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="/login/facebook"><img  width="400px" class="my-2" src="{{ asset('frontend/img/logo/facebook-login.png') }}" alt=""></a>
                        </div>
                        <div class="col-md-6">
                            <a href="/login/google"><img class="login_with_facebook" class="my-2" src="{{ asset('frontend/img/logo/google-signin-1x.png') }}" alt=""></a>
                        </div>

                    </div>

                </div>
                <!--login area start-->

                <!--register area start-->
                <div class="col-lg-6 col-md-6">

                    <div class="account_form register">
                        <h2>Register</h2>
                        <form action="/customer-register" method="POST">
                            @csrf
                            <p>
                                <label>Name  <span>*</span></label>
                                <input type="text" name="name" required>
                            </p>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <p>
                            <p>
                                <label>Phone Number  <span>*</span></label>
                                <input type="text" name="phone_number" required>
                            </p>
                            @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <p>
                            <p>
                                <label>Email address  <span>*</span></label>
                                <input type="email" name="email" required>
                             </p>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                             <p>
                                <label>Password <span>*</span></label>
                                <input type="password" name="password" required>
                             </p>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <p>
                                <label>Confirm Password <span>*</span></label>
                                <input type="password" name="password_confirmation">
                            </p>
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="login_submit">
                                <button type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--register area end-->
            </div>
        </div>
    </div>

    <!-- customer login end -->

   <!--brand area start-->
    <div class="brand_area brand_padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand_container owl-carousel ">
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand1.jpg" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand2.jpg" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand3.jpg" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand4.jpg" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand5.jpg" alt=""></a>
                        </div>
                        <div class="single_brand">
                            <a href="#"><img src="assets/img/brand/brand1.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--brand area end-->

@endsection



@section('modal')

    @include('frontend.layout.modal')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection
