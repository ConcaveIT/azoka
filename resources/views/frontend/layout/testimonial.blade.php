<div class="container">
    <div class="row justify-center">
        <div class="col-12">
            <!--testimonial area start-->
            <div class="testimonial_area  testimonial_about">
                <div class="about_testi_title">
                    <h2>What Our Customers Say ?</h2>
                </div>
                <div class="testimonial_container">
                    <div class="owl-carousel owl-theme testimonial_column3">

                        @forelse(\App\Testimonial::where('status', 1)->get() as $testimonial)
                        <div class="single_testimonial text-center w-full">

                                <div class="testimonial_icon_img">
                                    <img src="{{ asset('frontend/img/icon/testimonials-icon.png') }}" alt="">
                                </div>
                                <div class="text-center w-full">
                                    {!! $testimonial->testimonial !!}
                                    <a href="#">{{ $testimonial->name }}</a>
                                </div>


                        </div>
                        @empty
                        @endforelse


                    </div>
                </div>
            </div>
            <!--testimonial area end-->
        </div>

        <a class="text-center my-5 customButton p-2 rounded-full" href="/testimonial">Give a feedback</a>

    </div>



</div>

