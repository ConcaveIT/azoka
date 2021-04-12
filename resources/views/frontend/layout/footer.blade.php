
<style>
.add_p span {
    display: block;
    line-height: 15px;
}
.shop_toolbar_wrapper{
    display:none;
}
</style>

<footer class="py-2 mt-2">
    <div class="container">
        <div class="row items-center mb-2">
            <div class="col-lg-6 col-md-6 col-sm-6">
                 <img  style="width:150px; margin-left: -5px;margin-top: 15px;" src="{{ logo($general_setting->site_logo) }}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="widgets_container widget_newsletter">
                    <div class="subscribe_form">
                        <form id="mc-form" class="mc-form footer-newsletter" >
                            <input id="mc-email" type="email" autocomplete="off" placeholder="Subscribe with your email" />
                            <button id="mc-submit"><i class="icon-arrow-right-circle icons"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p>Address:</p>
                <p class="mb-2 add_p"> 
                <span><b>Azoka Limited</b></span><span>2nd Floor, House-54/A, Road-132,</span><span> Gulshan Circle-1, Dhaka-1212</span>
                </p>

                <p>
                    E-mail: shop@azoka.com.bd<br>
                    Call us: +8809614778899, +8801889983621, +8801889983624
                </p>

                <img src="{{ asset('frontend/img/logo/payments.png') }}" class="img-fluid" alt="">
            </div>


            <div class="col-lg-6 col-md-6 col-sm-12 flex justify-between">
                <div class="footer_right">
                    <h3 class="footer_title">My Account</h3>
                    <div class="footer_menu">
                        <ul>
                            @auth('customer')

                                <li><a class="" href="{{ route('logout_customer') }}">Logout <i class=""></i></a></li>


                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                            @endauth

                            <li><a href="{{ route('cart') }}">View Cart</a></li>
                            <li><a href="{{ route('my-account') }}">Order Status</a></li>

                        </ul>
                    </div>
                </div>

                <div class="footer_right">
                    <h3 class="footer_title">Customer Care</h3>
                    <div class="footer_menu">

                        <ul>
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/returns-exchange">Returns & Exchange</a></li>
                            <li><a href="contact-us">Contact Us</a></li>

                        </ul>
                    </div>
                </div>

                <div class="footer_right">

                    <h3 class="footer_title">Policies</h3>
                    <div class="footer_menu">

                        <ul>
                            <li><a href="/terms-conditions">Terms & Conditions</a></li>
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="copyright_area">
                    <p><a href="/disclaimer">Disclaimer</a> | &copy; 2021  <a href="/">Azoka</a>.  All rights reserved | Developed by <a href="http://vmsl.com.bd">VMSL</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="flex justify-end social_icons">
                    <li><a href="https://www.facebook.com/azoka.com.bd/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.instagram.com/azoka.bd/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

