@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection
<style>
    @media(max-width:767px){
.contact_map  iframe{
    height: 290px !important;
} 
}
</style>
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
          {{-- <div id="map"></div> --}}
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.049208118608!2d90.41537001498195!3d23.78126198457413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c72f7d45db81%3A0x5b723a27a97d4388!2sVirtual%20Market%20Solution%20Limited-VMSL!5e0!3m2!1sen!2sbd!4v1612604840759!5m2!1sen!2sbd" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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
                            <li><i class="fa fa-fax"></i>  Address :  2nd Floor, House-54/A, Road-132
                                <br>
                                Gulshan Circle-1, Dhaka-1212
                            </li>
                            <li><i class="fa fa-envelope-o"></i> <a href="mailto:info@azoka.com.bd">info@azoka.com.bd</a></li>
                            <li><i class="fa fa-envelope-o"></i> <a href="mailto:shop@azoka.com.bd">shop@azoka.com.bd</a></li>
                            <li><i class="fa fa-phone"></i><a href="tel:+880 1742-438722">+8809614778899</a></li>
                            <li><i class="fa fa-phone"></i><a href="tel:+880 1742-438722">+8801889983621</a></li>
                            <li><i class="fa fa-phone"></i><a href="tel:+880 1742-438722">+8801889983624</a></li>
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
