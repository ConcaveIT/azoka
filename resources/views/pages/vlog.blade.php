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
                            <li>Amar Care</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row flex-col">

                    <div class="shop_banner_area">
                        <iframe class="w-full h-screen" src="https://www.youtube.com/embed/{{ $vlog->video }}" frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                    </div>

                    <h1 class="text-4xl">{{ $vlog->title }}</h1>

                    <div class="description mt-2">
                        {!! $vlog->description !!}
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- my account end   -->

    <div class="container mb-2">
        <h3 class="text-xl">Products:

            @forelse($vlog->products as $product)
                <a class="text-red-600 hover:text-red-800" href="{{ route('product-details', [$product->category_id, $product->sub_category_id, $product->id]) }}">{{ $product->name }}</a> &nbsp;
            @empty
            @endforelse

        </h3>
    </div>

    <br>

    <div class="container">
        <div class="tab-content">

            <div class="tab-pane fade active" id="reviews" role="tabpanel" >
                <div class="reviews_wrapper">
                    <h2> {{ $vlog->comments()->count() }} comment for {{ $vlog->title }}</h2>

                    @forelse($vlog->comments as $comment)
                        <div class="reviews_comment_box">
                            <div class="comment_thmb">
                                <img src="assets/img/blog/comment2.jpg" alt="">
                            </div>
                            <div class="comment_text">
                                <div class="reviews_meta">
                                    <p><strong> {{ $comment->commented->name }} </strong>- {{ $comment->created_at }}</p>
                                    <span>{{ $comment->comment }}</span>
                                </div>
                            </div>

                        </div>
                    @empty
                    @endforelse

                    @auth('customer')

                        <form method="POST" action="{{ route('comment-vlog') }}">
                            @csrf
                            <div class="comment_title">
                                <h2>Share your opinion </h2>
                                <p>Your email address will not be published.  Required fields are marked </p>
                            </div>

                            <input type="hidden" name="vlog_id" value="{{ $vlog->id }}">

                            <div class="product_review_form">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="review_comment">Your comment *</label>
                                        <input class="p-5" type="text" name="comment" id="review_comment">
                                    </div>

                                </div>
                                <button type="submit">Submit</button>

                            </div>
                        </form>
                    @elseguest('customer')
                        <h1 class="text-xl font-weight-400">Create account and complete profile to comment.</h1>
                    @endauth
                </div>
            </div>
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
