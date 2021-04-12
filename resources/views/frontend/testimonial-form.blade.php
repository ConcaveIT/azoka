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
                            <li>Testimonial</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="">
                    <form method="POST" action="/testimonial" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-lg font-bold mb-2" for="username">
                                Display Name
                            </label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight " id="username"/>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-lg font-bold mb-2" for="username">
                                Your opinion
                            </label>
                            <textarea name="testimonial" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight " id="username"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline customButton" type="submit">
                                Submit
                            </button>

                        </div>
                    </form>

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
