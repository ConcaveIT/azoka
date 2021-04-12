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
                            <li>Returns & Exchange</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->



    <!--contact area start-->
    <div class="contact_area">
        <div class="container page_content">
            {!! $page ? $page->returns_exchange : '' !!}
        </div>
    </div>
    <!--contact area end-->

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
