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
                            <li> Beauty & shop</li>
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
                    <aside class="sidebar_widget">
                        <div class="widget_inner">

                            <form action="{{ route('filter-product-subshop') }}" method="GET">
                                @csrf

                                <div class="widget_list widget_filter">
                                    <h3>Select price range</h3>
                                    <div id="slider-range"></div>
                                    <input type="text" name="price" id="amount" />
                                </div>
                                <div class="widget_list widget_color">
                                    <h3>Select Brand</h3>
                                    <select class="form-control p-2" id="colorSelect">
                                        <option value="-1"></option>
                                        @php $brands = \App\Brand::all(); @endphp



                                        @forelse($brands as $brand)
                                            <option class="brand" value="{{ $brand->id }}">{{ $brand->name }}</option>

                                        @empty

                                        @endforelse

                                    </select>
                                </div>

                                <div class="widget_list widget_color">
                                    <h3>Select SIze</h3>
                                    <select class="form-control">
                                        <option value="-1"></option>
                                        @php $sizes = \App\Size::all(); @endphp

                                        @forelse($sizes as $size)
                                            <option class="size" value="{{ $size->id }}">
                                                {{ $size->name }}
                                            </option>

                                        @empty

                                        @endforelse
                                    </select>
                                </div>

                                <input type="hidden" id="sub_category_id" value="{{ $subshop->id }}">

                                <button id="filterSubShop" class="customButton filter_button" type="submit">Filter</button>

                            </form>

                        </div>


                        <div class="widget_list tags_widget mt-4">
                            <h3>Product tags</h3>
                            <div class="tag_cloud">
                                @php $tags = \App\Tag::all(); @endphp

                                @forelse($tags as $tag)

                                    <a class="customButton" href="{{ route('tag-search', $tag->name) }}">{{ $tag->name }}</a>
                                @empty

                                @endforelse


                            </div>
                        </div>


                    </aside>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="shop_banner_area">
                        <img src="{{ asset($subshop->image) }}" class="img-fluid single_slider w-100" alt="">
                    </div>
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
                    <div class="row shop_wrapper" id="chooseProduct">
                        @forelse($data as $product)
                            <div class="col-lg-4 col-md-4 col-sm-6 p-1">
                                <div class="single_product">
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('product-details', [$product->category->id, $product->sub_category->id, $product->id]) }}">
                                            <img src="{{ asset($product->image_primary) }}" alt=""></a>
                                        <a class="secondary_img" href="{{ route('product-details', [$product->category->id, $product->sub_category->id, $product->id]) }}">
                                            <img src="{{ asset($product->image_secondary) }}" alt=""></a>
                                        <div class="label_product">
                                            <span class="label_sale">-{{ $product->discount }}%</span>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                                <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}"
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
                                    <div class="product_content grid_content">
                                        <h4 class="product_name"><a href="{{ route('product-details', [$product->category->id, $product->sub_category->id, $product->id]) }}">
                                                {{ $product->name }}</a></h4>
                                        <div class="price_box">
                                            <span class="current_price">BDT {{ $product->price - round($product->price * $product->discount / 100) }}</span>
                                            @if(!$product->discount == 0)
                                                <span class="old_price">BDT {{ $product->price }}</span>
                                            @endif
                                        </div>
                                        <div class="add_to_cart">
                                            <a data-toggle="modal" data-target="#view-modal"
                                               class="quickButton"
                                               data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
                                            >+ Add to cart</a>
                                        </div>
                                    </div>
                                    <div class="product_content list_content">
                                        <h4 class="product_name"><a href="{{ route('product-details', [$product->category->id, $product->sub_category->id, $product->id]) }}">
                                                {{ $product->name }}</a></h4>
                                        <div class="price_box">
                                            <span class="current_price">BDT {{ $product->price - round($product->price * $product->discount / 100) }}</span>
                                            @if(!$product->discount == 0)
                                                <span class="old_price">BDT {{ $product->price }}</span>
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <p>{!! $product->short_description !!}</p>
                                        </div>
                                        <div class="list_action_wrapper">
                                            <div class="list_cart_btn">
                                                <a data-toggle="modal" data-target="#view-modal"
                                                   class="quickButton"
                                                   data-url="{{ route('dynamicModal',['id'=>$product->id])}}"
                                                >+ Add to cart</a>
                                            </div>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}"
                                                                            title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                                                    <li class="compare">
                                                        <a  title="Add to Compare">
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
                                    </div>
                                </div>
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
