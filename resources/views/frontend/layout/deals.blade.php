
<style>
@media(min-width:768px){
.dealhight {
    min-height: 500px !important;
}
.dealhight img{
    object-fit: contain !important;
}
}
@media only screen and (max-width: 767px){
.slider_section .slider_area{
    margin-top: 25px;
    padding-top: 5px;
}
}

.dealButton {
    background-color: #bd650aa3;
    padding: 10px;
    border-radius: 0px !important;
    width: 300px;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    line-height: 35px;
    border-radius: 10px !important;
}
.fa-gift{
    font-size: 32px;
}
@media(max-width: 767px) {
.fa-gift {
font-size: 24px;
}
.dealButton {
width: 160px;
font-size: 13px;
font-weight: 600;
line-height: 22px;
}
}
</style>


<div class="product_banner_static mb-95">
    <div class="container">

        <div class="section_title">
            <h2 class="">Azoka Special Deals</h2>
        </div>

        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product_banner_left">
                    <div class="product_carousel product_column1 owl-carousel">

                        @forelse(\App\Deal::latest()->where('expire', '>', now())->where('percentage', '!=', 'NULL')->get() as $deal)

                            <article class="single_product dealhight">
                                <figure>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('product-details', [$deal->product->category->slug, $deal->product->slug]) }}">
                                            <img src="{{ productImage($deal->product->image)}}" alt=""></a>
                                        <div class="label_product">
                                            <span class="label_sale">-{{ $deal->percentage }}%</span>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                               <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $deal->product->id }}"
                                                                        title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                                <li class="compare">
                                                    <a href="javascript:void(0)" class="compareButton" data-id="{{ $deal->product->id }}" title="Add to Compare">
                                                        <i class="icon-refresh icons"></i></a></li>
                                                <li class="quick_button">
                                                    <a data-toggle="modal" data-target="#view-modal"
                                                       class="quickButton"
                                                       title="Quick View"
                                                       data-url="{{ route('dynamicModal',['id'=>$deal->product->id])}}"
                                                    >
                                                        <i class="icon-magnifier-add icons"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <div class="product_content_inner">
                                            <h4 class="product_name"><a href="{{ route('product-details', [$deal->product->category->id, $deal->product->id]) }}">
                                                    {{ $deal->product->name }}</a></h4>
                                            <div class="price_box">
                                                <span class="current_price">BDT {!! $deal->product->price - ($deal->product->price * $deal->percentage / 100) !!}</span>
                                                @if(!$deal->percentage == 0)
                                                    <span class="old_price">BDT {{ $deal->product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="add_to_cart">
                                                <a data-toggle="modal" data-target="#view-modal"
                                                   class="quickButton"
                                                   data-url="{{ route('dynamicModal',['id'=>$deal->product->id])}}"
                                                >+ Add to cart</a>
                                            </div>
                                        </div>
                                        <div class="product_timing">
                                            <div data-countdown="{{ date('Y-m-d', strtotime($deal->expire))  }}"></div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>

                        @empty
                        @endforelse


                    </div>

                </div>
            </div>

            <div class="col-md-8 col-lg-8 col-sm-6">
                <section class="slider_section">
                    <div class="slider_area owl-carousel stop owl-theme">
                        @php
                           $data = \App\Deal::latest()->where('expire', '>', now())->where('price', '!=', 'NULL')->get();
                        @endphp
                        @forelse($data as $deal)

                            <div class="single_slider d-flex align-items-center w-full" id="mridth_deal" style="background-image: url('{{ productImage($deal->product->image)}}')">

                            <a class="hover:text-black"  href="{{ route('product-details', [$deal->product->category->slug, $deal->product->slug]) }}">
                                <div class="dealButton">
                                        <i class="fa fa-gift"></i>
                                            <br>
                                         Take the Deal at
                                            <br>
                                    <h1> BDT {{ $deal->price }} only !</h1>
                                </div>
                            </a>

                            </div>

                        @empty
                        @endforelse




                    </div>
                </section>
            </div>

        </div>
    </div>
</div>
