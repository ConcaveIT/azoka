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
                            <li>contact us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--contact map start-->
    <div class="contact_map">

          <div id="map"></div>

    </div>
    <!--contact map end-->

    <!--contact area start-->
    <div class="contact_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                   <div class="contact_message content">
                        <h3>contact us</h3>

                        <ul>
                            <li><i class="fa fa-fax"></i>  Address : 231 Wapda Road, West Rampura (2.11 mi)
                                <br>
                                Dhaka-1219, Bangladesh
                            </li>
                            <li><i class="fa fa-phone"></i> <a href="mailto:amarshop.bd2020@gmail.com">amarshop.bd2020@gmail.com</a></li>
                            <li><i class="fa fa-phone"></i> <a href="mailto:inf0@amarshop.com.bd">inf0@amarshop.com.bd</a></li>
                            <li><i class="fa fa-envelope-o"></i><a href="tel:+880-1998916331">+880-1998916331</a></li>
                            <li><i class="fa fa-envelope-o"></i><a href="tel:+880-1891962812">+880-1891962812</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                   <div class="contact_message form">
                        <h3>Tell us your inquiry</h3>
                        <form id="contact-form" method="POST"  action="{{ asset('frontend') }}/mail.php">
                            <p>
                               <label> Your Name (required)</label>
                                <input name="name" placeholder="Name *" type="text">
                            </p>
                            <p>
                               <label>  Your Email (required)</label>
                                <input name="email" placeholder="Email *" type="email">
                            </p>
                            <p>
                               <label>  Subject</label>
                                <input name="subject" placeholder="Subject *" type="text">
                            </p>
                            <div class="contact_textarea">
                                <label>  Your Message</label>
                                <input placeholder="Message *" name="message" type="text"  class="form-control2 py-5" />
                            </div>
                            <button class="mt-4 hover:text-black" type="submit"> Send</button>
                            <p class="form-messege"></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--contact area end-->

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
