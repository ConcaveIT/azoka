@extends('layouts.app', ['activePage' => 'slider', 'titlePage' => __('Add Slide Image')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('slider') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Upload Slide Images') }}</h4>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Slide Image') }}</label>

                                    <div class="col-sm-7">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="slide_image" id="input-name" type="file" required="true" aria-required="true"/>
                                            @if ($errors->has('slide_image'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('slide_image') }}</span>
                                            @endif

                                        <div class="form-group{{ $errors->has('slide_title') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="slide_title" id="input-name" type="text" placeholder="{{ __('Slide Title') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('slide_title'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('slide_title') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('slide_exert') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('slide_exert') ? ' is-invalid' : '' }}" name="slide_exert" id="input-name" type="text" placeholder="{{ __('Short Description') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('slide_exert'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('slide_exert') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Upload') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

                <div class="col-md-12">

                    <div class="card ">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">{{ __('Available Slides') }}</h4>
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

                                @forelse($slideImages as $slideImage)

                                        <img width="200px" class="img-thumbnail" src="{{ asset($slideImage->image) }}" alt="">
                                    <a onclick="return confirm('Are you sure?')" href="{{ route('slider.delete', $slideImage->id) }}"><i class="fa fa-remove text-danger mr-2"></i></a>

                                @empty

                                @endforelse


                            </div>


                        </div>


                    </div>
                </div>


            </div>
        </div>

    </div>
    </div>
@endsection
@endcanany
