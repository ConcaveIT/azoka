@extends('layouts.app', ['activePage' => 'create-vlog', 'titlePage' => __('Create Vlog')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('amar-care.store') }}" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Create Vlog') }}</h4>
                                <p class="card-category">{{ __('Vlog information') }}</p>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Vlog Title') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="title" id="input-name" type="text" placeholder="{{ __('Vlog Title') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Category') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="category_id" required
                                                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            <hr>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                @if ($errors->has('category_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Products') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">

                                                <select multiple name="products[]" required
                                                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                    @forelse($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        <hr>
                                                    @empty
                                                    @endforelse
                                                </select>


                                                @if ($errors->has('product_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('sub_category_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr>


                                    <br>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Video Code') }}</label>
                                        <div class="col-sm-7">
                                            <div class="{{ $errors->has('image_primary') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('image_primary') ? ' is-invalid' : '' }}" name="video" id="input-image_primary" type="text" required />
                                                @if ($errors->has('image_primary'))
                                                    <span id="image_primary-error" class="error text-danger" for="input-image_primary">{{ $errors->first('image_primary') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <br>


                                    <div class="row">
                                        <label class="col-sm-2 col-form-label" for="input-password">{{ __('Vlog Description') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                                <textarea class="w-100" name="description" id="" cols="" rows="10"></textarea>
                                                @if ($errors->has('description'))
                                                    <span id="description-error" class="error text-danger" for="input-product_description">{{ $errors->first('description') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Create Vlog') }}</button>
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

