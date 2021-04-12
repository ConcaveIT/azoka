@extends('layouts.app', ['activePage' => 'product-show', 'titlePage' => __('Product Management')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="" autocomplete="off" class="form-horizontal">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Product Management') }}</h4>
                            </div>
                            <div class="card-body ">
                                @if (session('status'))
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <i class="material-icons">close</i>
                                                </button>
                                                <span>{{ session('status') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-success">{{ __('Make Featured') }}</button>
                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <a href="" class="btn btn-primary text-white">{{ __('Give Sale') }}</a>
                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                            </div>

                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('products.edit', $productId) }}" class="btn btn-info">{{ __('Edit') }}</a>
                            </div>


                        </div>


                    </form>
                </div>




            </div>
        </div>

    </div>
    </div>
@endsection
@endcanany
