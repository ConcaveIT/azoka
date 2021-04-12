@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')
@endsection

@section('content')
<style>
.about_section {
    border-top: 1px solid #e2e2e2 !important;
}    
</style>

    <!--about section area -->
    <section class="about_section">
       <div class="container pt-5">
            <div class="row">
                <div class="col-12">
                   <p>
Why travel to distant stores and waste time when you can easily buy all your groceries online? Enjoy the comfort of digital shopping with Azoka.
Azoka.com.bd is an online grocery shop in Dhaka, Bangladesh, providing home delivery services. It is an e-commerce website which will take care of your grocery needs ranging from your basic chaldal to imported goods like branded chocolates and condiments that are hard to come about in physical stores these days, and other everyday necessary household items, such as home grooming necessities and baby care items like diapers and baby food.
Azoka.com.bd offers everything to make sure you have the best online shopping in Bangladesh. All ingredients needed for you to make your gourmet home cooked meals, all goods needed to have a groomed home and all goods needed to take care of your baby is here at Azoka.com.bd, with around the clock convenient delivery and customer services.
All our products, local and imported, are individually inspected before delivering them to you, with care, at your convenience. This way we can ensure product quality and efficient delivery of your goods.
Azoka.com.bd is here with an aim to enhance your experience with online shopping and delivery services.
Shopping online for your home has never been easier: the functionality of your local bazar at the comfort of your own home. You pick what you need from our wide range of goods on our website or app, and we deliver it at your doorstep, hassle free.
We firmly believe “প্রয়োজন যেখানে Azoka সেখানে”. You need it, we have it.                       
                       
                   </p>
                </div>
            </div>
        </div>
    </section>
    <!--about section end-->

    @include('frontend.layout.testimonial')


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
