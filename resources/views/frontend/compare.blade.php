@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')


    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-10">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Compare</li>
                        </ul>
                    </div>
                </div>
                <div class="col-2">
                    <a class="text-danger" href="/compare/remove">Clear <i class="fa fa-remove"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    @php
      $compare = \session()->get('compare') ?? [];
    @endphp

    <div class="container">
        <div class="row">
            @forelse($compare as $data)

                @php $product = \App\Product::findOrFail($data);
                    $product_variant = $product->variant->groupBy('name');
                @endphp



            <div class="col-4 ">

                <div class="flex flex-column justify-between h-100">
                    <div>
                        <a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">
                        <img src="{{ productImage($product->image) }}" class="img-thumbnail" alt="">
                        </a>
                    </div>
                    <table class="table table-striped table-hover row">
                        <thead>

                        <tr>
                            <th scope="col">Name</th>

                            <th scope="col">{{ $product->name }}</th>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <th>BDT {{ $product->price }}</th>
                        </tr>
                        <tr>
                            <th>Discounted Price</th>
                            <th>BDT {{ $product->promotion_price }}</th>
                        </tr>
                        <tr>
                            <th>Variation</th>
                            <th>
                                @forelse($product_variant as $name => $variant)

                                    <label>{{ ucfirst($name) }}: </label>
                                    <div class="size">
                                        @forelse($variant as $v)
                                            <div class="form-check-inline">

                                                <label class="form-check-label flex flex-col-reverse items-center">
                                                    <a>{{ ucfirst($v->pivot->item_code) }}</a>

                                                </label>
                                            </div>
                                        @empty
                                        @endforelse


                                    </div>

                                    <br>

                                @empty
                                @endforelse
                            </th>
                        </tr>

                        <tr>
                            <th>Brand</th>
                            <th>{{ $product->brand->name }}</th>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <th>{{ $product->category->name }}</th>
                        </tr>
                        <tr>
                            <th>Expiry Date</th>
                            <th>{{ $product->expiry_date }}</th>
                        </tr>
                        <tr>
                            <th>Available</th>
                            <th>{{ $product->qty }}</th>
                        </tr>

                        {{--                    <tr>--}}
                        {{--                        <th>Specification</th>--}}
                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <th>Compositions</td>--}}
                        {{--                        <td>{{ $product->specification ? $product->specification->compostions : '' }}</td>--}}
                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <td>Styles</td>--}}
                        {{--                        <td>{{ $product->specification ? $product->specification->styles : '' }}</td>--}}
                        {{--                    </tr>--}}
                        {{--                    <tr>--}}
                        {{--                        <td>Properties</td>--}}
                        {{--                        <td>{{ $product->specification ? $product->specification->properties : '' }}</td>--}}
                        {{--                    </tr>--}}

                        </thead>
                    </table>
                </div>



            </div>

            @empty
            @endforelse

        </div>
    </div>



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


