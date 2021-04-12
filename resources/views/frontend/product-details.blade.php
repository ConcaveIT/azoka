@extends('frontend.layout.master')

@push('scripts')

@endpush
   <!--header area start-->
@section('header')

    @include('frontend.layout.header')

@endsection
    <!--header area end-->

@section('content')

<style>
.action_links ul li i, .modal_social ul li i {
position: relative;
top: 30%;
}
.signle_variant_label{
width: 63px;
display: inline-block;
}
.signle_variant{
display: inline-block;
padding-right: 20px;
text-align: center;
padding-top: 20px;
}

.signle_variant_first{
padding-top: 0px;
}
.signle_variant_label {
width: 75px;
}
.combo_products img{
width: 70px;
height: auto;
}
.combo_products span {
text-align: left;
}
.uniq{
padding-top: 25px;
}


@media(max-width:787px){
.uniq{
padding:2px !important;
}
.uniqs{
padding:2px 2px 2px 5px !important;
}
}
.modal_social {
    text-align: left;
    padding-top: 15px;
}

.owl-prev, .owl-next {
    padding-top: 7px;
}
</style>
    
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>product details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <div class="product_details mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    @php $exploded_img = explode(',', $product->image); @endphp
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                <img id="zoom1" src="{{productImage($product->image)}}" data-zoom-image="{{productImage($product->image)}}" alt="big-1">
                            </a>
                        </div>
                        <div class="single-zoom-thumb mainclass">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
        
                                @if($exploded_img)
                                @foreach($exploded_img as $image)
                                    <li class="single_item">
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="{{url('pos/public/images/product/'.$image)}}"
                                        data-zoom-image="{{url('pos/public/images/product/'.$image)}}">
                                            <img src="{{url('pos/public/images/product/'.$image)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-7 col-md-7" id="app">
                    <div class="product_d_right">
                       <form action="#" >
                            <div class="productd_title_nav">
                                <h1><a href="#"> <strong>{{ $product->name }}</strong> </a></h1>
                                <input type="hidden" id="productId" value="{{ $product->id }}">

                                <input type="hidden" id="productPrice" value="{{price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) }}">
                                
                            </div>

                           <div class=" product_ratting">
                               <ul>
                                   @for($i=0;  $i<$product->averageRate(); $i++)
                                   <li><a href="#"><i class="ion-android-star"></i></a></li>
                                   @endfor
                               </ul>
                           </div>
                           @php
                                $datas = DB::table('products')->where('id', $product->id)->where('type', 'combo')->first();
                                if($datas){
                                    $ids = explode(',', $datas->product_list);
                                    $qtys = explode(',', $datas->qty_list);
                                    $price = explode(',', $datas->price_list);
                                }
                            @endphp
                            @if($datas)
                            <h3 style="font-size: 20px;padding-bottom: 10px;">Products included in this package. </h3>
                                @foreach($ids as $key => $id)
                                    <div class="row combo_products">
                                            @php
                                                $image = explode(',', combo_prodduct_details_by_id($id)->image);
                                            @endphp
                                            <div class="col-2 col-sm-2 col-md-2 uniqS"><img src="{{productImage($image[0])}} " alt=""></div>
                                            <div class="col-6 col-sm-6 col-md-6 uniq"> <span>{{ combo_prodduct_details_by_id($id)->name }}</span> </div>
                                            <div class="col-2 col-sm-2 col-md-2 uniq"> <span> QTY: {{ $qtys[$key] }} </span></div>
                                            <div class="col-2 col-sm-2 col-md-2 uniq"> <span>BDT {{$price[$key]*$qtys[$key]}}</span> </div>
                                    </div>
                                @endforeach
                                <br>
                                <br>
                           @endif
                           <div class="price_box">
                               <span class="current_price" id="updatedPrice">BDT 
                                   @if($deal=get_deal_price($product->id, $product->price)) 
                                        {{$deal}}
                                   @elseif($product->promotion_price)
                                        {{$product->promotion_price}}
                                    @else
                                        {{ $product->price }}
                                   @endif
                                </span>
                                   @if(get_deal_price($product->id, $product->price)) 
                                        <span class="old_price" style="padding-left: 10px;"> BDT {{ $product->price }}</span>
                                   @elseif($product->promotion_price)
                                        <span class="old_price" style="padding-left: 10px;"> BDT {{ $product->price }}</span>
                                   @endif
                           </div>

                            {{-- <div class="product_desc">
                                {!! $product->product_details !!}
                            </div> --}}
                            @php
                                $size_variant = DB::table('product_variants')->where('product_id', $product->id)->where('variant_by', 'size')->get();
                                $color_variant = DB::table('product_variants')->where('product_id', $product->id)->where('variant_by', 'color')->get();
                                $weight_variant = DB::table('product_variants')->where('product_id', $product->id)->where('variant_by', 'weight')->get();
                            @endphp
                            @if(count($size_variant) > 0 || count($color_variant) > 0 || count($weight_variant) > 0)
                            <div class="product_variant color">
                                <h3>Available Options</h3>
                                @if(count($size_variant) > 0)
                                    <div class="signle_variant_label">
                                        <h3 for=""> <strong>Size:</strong> </h3>
                                    </div>
                                    @foreach ($size_variant as $size_data)
                                        <div class="signle_variant signle_variant_first">
                                            <input type="radio" class="variant"
                                                data-item-code="{{ $size_data->item_code }}" 
                                                name="{{  $size_data->variant_by }}" value="{{$size_data->id }}"
                                                data-add-price="{{$size_data->additional_price??0}}" 
                                                data-quantity="{{  $size_data->qty }}" data-original-price="{{$product->price}}">
                                                <br>
                                                <label for="">{{ $size_data->variant_name }}</label>
                                        </div>
                                    @endforeach
                                    <br>
                                @endif
                                @if(count($color_variant) > 0)
                                    <div class="signle_variant_label">
                                        <h3 for=""> <strong>Color:</strong> </h3>
                                    </div>
                                    @foreach ($color_variant as $color_data)
                                        <div class="signle_variant">
                                            <input type="radio" class="variant"
                                                data-item-code="{{ $color_data->item_code }}" 
                                                name="{{  $color_data->variant_by }}" value="{{$color_data->id }}"
                                                data-add-price="{{  $color_data->additional_price??0 }}" 
                                                data-quantity="{{  $color_data->qty }}" data-original-price="{{$product->price}}">
                                                <br>
                                                <label for="">{{ $color_data->variant_name }}</label>
                                        </div>
                                    @endforeach
                                    <br>
                                @endif
                                
                                @if(count($weight_variant) > 0)
                                    <div class="signle_variant_label">
                                        <h3 for="" style="padding-right: 10px;"> <strong>Weight:</strong> </h3>
                                    </div>
                                    @foreach ($weight_variant as $weight_data)
                                        <div class="signle_variant">
                                            <input type="radio" class="variant"
                                                data-item-code="{{ $weight_data->item_code }}" 
                                                name="{{  $weight_data->variant_by }}" value="{{$weight_data->id }}"
                                                data-add-price="{{  $weight_data->additional_price??0 }}" 
                                                data-quantity="{{  $weight_data->qty }}" data-original-price="{{$product->price}}">
                                                <br>
                                                <label for="">{{ $weight_data->variant_name }}</label>
                                        </div>
                                    @endforeach
                                    <br>
                                @endif
                            </div>
                            @endif


                            <div class="mt-2">
                                <label for="">Inventory : {!! $product->qty > 0 ? $product->qty : 0 !!} products available</label>
                            </div>
                            <div class="product_variant quantity">
                                <label>quantity</label>
                                <input min="1" max="100000" id="count" value="1" type="number">
                                @if($product->qty > 0)
                                <a href="javascript:void(0)" class="customButton px-2" id="addToCart">add to cart</a>
                                @else
                                <p class="ml-2 font-bold text-danger">Out of Stock!</p>
                                @endif

                            </div>
                            <div class=" product_d_action">
                               <ul>
                                   <li><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}" title="Add to Wishlist">+ Add to Wishlist</a></li>
                                   <li><a href="javascript:void(0)" class="compareButton" data-id="{{ $product->id }}" title="Add to Compare">+ Add to Compare</a></li>
                               </ul>
                            </div>
                            <div class="product_meta">
                                <div>Category: <a href="{{ route('shop', $category->slug) }}">{{ $category->name }}</a></div>
                                @if($product->brand)
                                <div>Brand: <a href="{{ route('brand-search', $product->brand->title) }}">{{ $product->brand->title }}</a></div>
                                @endif

                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url_by_catID_and_slug($product->category_id, $product->slug)) }}"><i class="fa fa-facebook"></i></a></li>
                                        <li class="instagram"><a href="https://www.instagram.com/sharer.php?u={{ urlencode(url_by_catID_and_slug($product->category_id, $product->slug)) }}"><i class="fa fa-instagram"></i></a></li>
                                        <li class="twitter"><a href="https://twitter.com/share?url={{ urlencode(url_by_catID_and_slug($product->category_id, $product->slug)) }}"><i class="fa fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info mb-57">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li >
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews ({{ $product->comments()->count() }})</a>
                                </li>

                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">
                                    {!! $product->product_details !!}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel" >
                                <div class="reviews_wrapper">
                                    <h2>{{ $product->comments()->count() }} review for {{ $product->name }}</h2>

                                    @forelse($product->comments as $comment)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb">
                                                <img src="assets/img/blog/comment2.jpg" alt="">
                                            </div>
                                            <div class="comment_text">
                                                <div class="reviews_meta">
                                                    <div class="star_rating">
                                                        <ul>
                                                            @for($i=0; $i<$comment->rate; $i++)
                                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <p><strong>{{ $comment->commented->name }} </strong>- {{ $comment->created_at }}</p>
                                                    <span>{{ $comment->comment }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                    @endforelse


                                    @auth('customer')

                                        <form method="POST" action="{{ route('rate-product') }}">
                                            @csrf
                                    <div class="comment_title">
                                        <h2>Add a review </h2>
                                        <p>Your email address will not be published.  Required fields are marked </p>
                                    </div>
                                    <div class="product_ratting mb-10">
                                        <h3>Your rating</h3>

                                        <ul>
                                            <input type="radio" name="star" value="5" required>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="4" required>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="3" required>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="2" required>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                        <ul>
                                            <input type="radio" name="star" value="1" required>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                        </ul>
                                    </div>

                                    <input type="hidden" id="productId" name="product_id" value="{{ $product->id }}">

                                    <div class="product_review_form">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="review_comment">Your review *</label>
                                                <textarea name="comment" id="review_comment" required></textarea>
                                            </div>

                                        </div>
                                        @if(Session::has('error'))
                                            <h2 class="text-danger mt-2">{{ Session::get('error') }}</h2>
                                        @endif
                                        <button type="submit">Submit</button>

                                    </div>
                                        </form>
                                    @elseguest('customer')
                                            <h1 class="text-xl font-weight-400">Create account and complete profile to review.</h1>
                                        @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->

    <!--product area start-->
    
    <section class="product_area related_products mb-57">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title psec_title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>

            <div id="owl-demo-2" class="owl-carousel owl-theme product_column4 product_carousel">

                @forelse($related_products as $related_product)
                   
                    <article class=" single_product m-2">
                        <figure class="h-full flex flex-column justify-between">
                            <div class="product_thumb">
                                <a class="primary_img" href="{{ route('product-details', [$related_product->category->slug, $related_product->slug]) }}">
                                    <img src="{{ productImage($related_product->image) }}" alt=""></a>
                                <div class="action_links">
                                    <ul>
                                        <li class="wishlist">
                                            <a href="javascript:void(0)" class="wishlistButton" data-id="{{ $related_product->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                        <li class="compare">
                                            <a href="javascript:void(0)" class="compareButton" data-id="{{ $related_product->id }}" title="Add to Compare"><i class="icon-refresh icons" ></i>
                                            </a>
                                        </li>
                                        <li class="quick_button">
                                            <a data-toggle="modal" data-target="#view-modal"
                                               class="quickButton"
                                               title="Quick View"
                                               data-url="{{ route('dynamicModal',['id'=>$related_product->id])}}"
                                            >
                                                <i class="icon-magnifier-add icons"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <figcaption class="product_content">
                                <h4 class="product_name"><a href="{{ route('product-details', [$related_product->category->slug, $related_product->slug]) }}">
                                        {{ $related_product->name }}</a></h4>
                                <div class="price_box">
                                    @if($deal=get_deal_price($related_product->id, $product->price)) 
                                            {{$deal}}
                                            <span class="old_price">BDT {{ $related_product->price }}</span>
                                    @elseif($related_product->promotion_price)
                                            {{$related_product->promotion_price}}
                                            <span class="old_price">BDT {{ $related_product->price }}</span>
                                        @else
                                            {{ $related_product->price }}
                                    @endif

                                </div>



                                <div class="add_to_cart">
                                    <a data-toggle="modal" data-target="#view-modal"
                                       class="quickButton"
                                       data-url="{{ route('dynamicModal',['id'=>$related_product->id])}}"
                                    >+ Add to cart</a>
                                </div>
                            </figcaption>
                        </figure>
                    </article>

                @empty
                <h3>No related product found.</h3>
                @endforelse
            </div>
        </div>
    </section>
    <!--product area end-->

    <!--brand area start-->
    @include('frontend.layout.brand')
    <!--brand area end-->

@endsection

@section('modal')

@forelse($related_products as $related_product)
    @include('frontend.layout.modal', ['data' => $related_product])
@empty
@endforelse

@endsection





@section('script')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection

<div id="view-modal-review" class="modal fade"
     tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: ;">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="ion-android-close"></i></span>
            </button>

            <div class="modal_body">
                <div class="container">
                    <div class="row">

                        <ul class="flex justify-center w-full">
                            <li><a class="rating" data-value="1" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="2" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="3" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="4" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                            <li><a class="rating" data-value="5" href="#"><i class="ion-android-star text-4xl"></i></a></li>
                        </ul>

                        <input id="product" type="hidden" value="{{ $product->id }}">
                        <input id="star" type="hidden" value="">

                        <div class="w-full text-center">

                            <input type="text" id="comment" class="border border-pink-100 w-full p-4 mb-2">

                            <button id="customerRating" class="customButton py-2 px-4">Rate</button>
                        </div>


                    </div>

                </div>
            </div>



        </div>
    </div>
</div><!-- /.modal -->

<script>
setInterval(function(){ 
   $('.owl-next').click(); 
 }, 3000);  

</script>




