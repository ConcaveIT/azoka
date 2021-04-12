
<style>
.button_section{
    text-align: center;
}    
.addtoform{
    padding: 25px 0px;
}
.prodetail{
    padding-top: 15px;
}
.carousel-caption {
     bottom: 0px;
     padding-top: 0px;
    padding-bottom: 0px;
}
.banner_gallery_area {
    padding: 40px 0;
}

#demo, .carousel-inner, .carousel-item{
    height: 480px !important;
}

.carousel-item img{
    max-height:350px !important;
    margin: 0 auto;
    object-fit: contain;
}
#demo .fa{
    color: #af4e05;
    font-size: 30px;
}

@media (min-width:768px){
.padding_o{
    padding: 0px;
}

}

.colBanner6 .single_product {
    height: 280px !important;
}

.colBanner6 .add_to_cart {
    background: #9A5826 !important;
    color: #fff !important;
    text-align: center;
    padding: 0px 5px 2px 6px;
    border-radius: 5px;
}
.colBanner6  .add_to_cart a {
    font-size: 14px;
}
.colBanner6 .product_content h4 {
    font-size: 14px;
    line-height: 18px;
    font-weight: 400;
    text-transform: capitalize;
    margin-bottom: 10px;
}
.colBanner6 .product_carousel .product_thumb a img {
    height: 180px !important;
}
.colBanner6 .single_product:hover .add_to_cart {
    bottom: 95px !important;
}

</style>


<div class="continer">
    <div class="row">
        <div class="col-md-12 padding_o">
            <section class="slider_section">
                <div class="slider_area owl-carousel stop owl-theme">
                    @forelse($sliders as $slider)
            
                        <div class="single_slider d-flex align-items-center w-full" style="background-image: url('{{ sliderImage($slider->image)}}')">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="slider_content">
                                            <h1 class="text-white">{{ $slider->title }}</h1>
                                            <p class="text-white">
                                                {{ $slider->exert }}
                                            </p>
                                            {{-- <a href="#">+ Shop Now </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </section>
        </div>

    </div>
</div>


<div class="product_area mt-5 colBanner6">
    <div class="container">
        <div id="owl-demo-2" class="owl-carousel owl-theme product_column6 product_carousel">
            @forelse($allProducts as $newProduct)
                <article class="single_product m-2">
                    <figure class="h-full flex flex-column justify-between">
                        <div class="product_thumb">
                            <a class="primary_img" href="{{ route('product-details', [$newProduct->category->slug, $newProduct->slug]) }}">
                                <img src="{{ productImage($newProduct->image) }}" alt=""></a>
                            <div class="action_links">
                                <ul>
                                    <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $newProduct->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                    <li class="compare">
                                        <a href="javascript:void(0)" class="compareButton" data-id="{{ $newProduct->id }}" title="Add to Compare">
                                            <i class="icon-refresh icons"></i></a></li>
                                    <li class="quick_button">
                                        <a data-toggle="modal" data-target="#view-modal"
                                           class="quickButton"
                                           title="Quick View"
                                           data-url="{{ route('dynamicModal',['id'=>$newProduct->id])}}"
                                        >
                                            <i class="icon-magnifier-add icons"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <figcaption class="product_content">
                            <h4 class="product_name"><a href="{{ route('product-details', [$newProduct->category->slug, $newProduct->slug])}}">
                                    {{ $newProduct->name }}</a></h4>
                            <div class="price_box">
                                <span class="current_price">BDT {{ $newProduct->promotion_price ?? $newProduct->price }}</span>
                                @if($newProduct->promotion_price)
                                    <span class="old_price">BDT {{ $newProduct->price }}</span>
                                @endif
                            </div>
                            <div class="add_to_cart">
                                <a data-toggle="modal" data-target="#view-modal"
                                   class="quickButton"
                                   data-url="{{ route('dynamicModal',['id'=>$newProduct->id])}}"
                                >+ Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>

            @empty
            @endforelse
        </div>
    </div>
</div>
