@extends('frontend.layout.master')


    <!--header area start-->
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
                            <li> {{ $shop->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--shop  area start-->
    <div class="shop_area shop_reverse mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                   <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">

                            <form action="{{ route('filter-product') }}" method="GET">
                                @csrf
                                <div class="widget_list widget_filter">
                                    <h3>Price range</h3>
                                    <div id="slider-range"></div>
                                    <input class="priceSlider" type="text" name="price" id="amount" />
                                </div>
                                <div class="widget_list widget_color">
                                    <h3>Brand</h3>
                                    <select name="brand" class="form-control p-2" id="colorSelect">
                                        <option value="-1">All Brand</option>
                                        @forelse(\App\Brand::all() as $brand)
                                            <option class="brand" value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <input type="hidden" id="category_id" value="{{ $shop->id }}">

                                <button id="filterShop" class="customButton filter_button" type="submit">Filter</button>

                            </form>

                        </div>
                    </aside>


                    <!--sidebar widget end-->
                </div>
                <div class="col-lg-9 col-md-12">
                    <!--shop wrapper start-->
                    @php
                     $page = $_GET['page'] ?? 1;
                    @endphp
                    @if($page == 1)
                    <div class="shop_banner_area">
                        <img src="{{ categoryImage($shop->image) }}" class="img-fluid single_slider w-100" alt="">
                    </div>
                    @endif

                    <!--shop toolbar start-->
           
                    @if($data)
                    <div class="shop_toolbar_wrapper">
                        <div class="shop_toolbar_btn">

                            <button data-role="grid_3" type="button" class="active btn-grid-3" data-toggle="tooltip" title="3"></button>


                            <button data-role="grid_list" type="button"  class="btn-list" data-toggle="tooltip" title="List"></button>
                        </div>
                        <div class="page_amount">

                        </div>
                    </div>
                    @endif



                    @if($data)
                     <!--shop toolbar end-->
                     <div class="row shop_wrapper shop_page" id="chooseProduct">

                         @forelse($data as $product)
                         @php
                            $result = DB::table('products')->where('id', $product->id)->first();
                            $product_slug = $result->slug;
                        @endphp
                        <div class="col-lg-4 col-md-4 col-sm-6 p-1">
                            <article class=" single_product m-2">
                                <figure class="h-full flex flex-column justify-start">
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('product-details', [$product->category->slug, $product_slug]) }}">
                                            {{-- <img src="{{ productImage($product->image) }}" alt=""></a> --}}
                                            <img src="{{ productImage($product->image) }}" alt=""></a>
                                        <div class="action_links">
                                            <ul>
                                                <li class="wishlist">
                                                    <a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}"
                                                                        title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                                <li class="compare">
                                                    <a href="javascript:void(0)" class="compareButton" data-id="{{ $product->id }}" title="Add to Compare">
                                                        <i class="icon-refresh icons"></i></a></li>
                                                <li class="quick_button">
                                                    <a data-toggle="modal" data-target="#view-modal"
                                                       class="quickButton"
                                                       title="Quick View"
                                                       data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
                                                    >
                                                        <i class="icon-magnifier-add icons"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="{{ route('product-details', [$product->category->slug, $product_slug]) }}">
                                                {{ $product->name }}</a></h4>
                                        <div class="price_box">
                                            <span class="current_price">BDT {{ $product->promotion_price ?? $product->price }}</span>
                                            @if($product->promotion_price)
                                                <span class="old_price">BDT {{ $product->price }}</span>
                                            @endif
                                        </div>
                                        <div class="add_to_cart">
                                            <a data-toggle="modal" data-target="#view-modal"
                                               class="quickButton"
                                               data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
                                            >+ Add to cart</a>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>

                         @empty

                         @endforelse

                    </div>
                    @endif
                    @if($data)
                    <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                            {{ $data->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->

@section('modal')

    @include('frontend.layout.modal')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection



@endsection
