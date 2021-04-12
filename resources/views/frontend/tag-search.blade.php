@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')


<div class="container">
    <h1 class="text-4xl my-5">Products with Tag: '{{ $tag->name ?? '' }}'</h1>
    <hr>
    <div class="row">
        @php
            var_dump($tag);
        @endphp
        
        @forelse($tag->products as $product)

            <div class="single_product col-md-3 col-sm-6 h-auto">
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
                            <li class="wishlist"><a href="javascript:void(0)" class="wishlistButton" data-id="{{ $product->id }}" title="Add to Wishlist"><i class="icon-heart icons"></i></a></li>
                            <li class="compare"><a href="#" title="Add to Compare"><i class="icon-refresh icons"></i></a></li>
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

            </div>

        @empty
        @endforelse
    </div>
</div>

@endsection



@section('modal')

    @include('frontend.layout.modal')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection
