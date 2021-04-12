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
                <div class="row">
                    @forelse($vlogs as $vlog)
                        <div class="col-md-3 col-lg-3 col-sm-6">
                            <div class="single_banner m-2">
                                <div class="banner_thumb img-thumbnail">
                                    <a href="{{ route('vlog', [$vlog->category->id, $vlog->id]) }}">
                                        <img class="img-fluid banner_image" src="http://img.youtube.com/vi/{{ $vlog->video }}/mqdefault.jpg" alt="">
                                    </a>
                                </div>
                                <div class="banner_text">
                                    <h4 class="text-xl">{{ $vlog->title }}</h4>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- my account end   -->



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
