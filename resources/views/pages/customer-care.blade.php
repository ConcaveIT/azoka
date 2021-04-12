@extends('layouts.app', ['activePage' => 'customer-care', 'titlePage' => __('Customer Care')])

@canany(['access-all-data', 'access-admin-data'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('customer-care') }}" autocomplete="on" class="form-horizontal">

                    @csrf
                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Customer Care') }}</h4>
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
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('About Us') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <textarea class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="about_us">{{ $page ? $page->about_us : '' }}</textarea>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Returns & Exchange') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="returns_exchange">{{ $page ? $page->returns_exchange : '' }}</textarea>
                                                @if ($errors->has('name'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Contact Us') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <textarea class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="contact_us">{{ $page ? $page->contact_us : '' }}</textarea>
                                                @if ($errors->has('name'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Save') }}</button>
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
