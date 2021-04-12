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
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->


    <!--wishlist area start -->
    <div class="wishlist_area">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc wishlist">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
{{--                                            <th class="product_quantity">Stock Status</th>--}}
                                            <th class="product_total">Add To Cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($wishlist as $wish)
                                        <tr>
                                            <td class="product_remove"><a href="/wishlist/remove/{{ $wish->id }}">X</a></td>
                                            <td class="product_thumb">
                                                <a href="{{ route('product-details', [$wish->product->category->slug, $wish->product->slug]) }}">
                                                    <img src="{{ productImage($wish->product->image) }}" alt=""></a></td>
                                            <td class="product_name">
                                                <a href="{{ route('product-details', [$wish->product->category->slug, $wish->product->slug]) }}">
                                                    {{ $wish->product->name }}</a></td>
                                            <td class="product-price">{{ $wish->product->price }}</td>
                                            {{--                                            <td class="product_quantity">In Stock</td>--}}
                                            <td class="product_total"><a data-toggle="modal" data-target="#view-modal"
                                                 class="quickButton"
                                                 data-url="{{ route('dynamicModal',['id'=>$wish->product->id])}}"
                                                >Add to cart</a></td>


                                        </tr>
                                    @empty
                                    @endforelse


                                    </tbody>
                                </table>
                            </div>

                        </div>
                     </div>
                 </div>

            </form>

        </div>
    </div>
    <!--wishlist area end -->


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


