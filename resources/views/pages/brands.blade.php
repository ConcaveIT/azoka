@extends('layouts.app', ['activePage' => 'brand', 'titlePage' => __('Brand')])

@canany(['access-all-data', 'access-admin-data'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('brands.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Add Brand') }}</h4>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Brand Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Brand Name') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Brand Image') }}</label>
                                        <div class="col-sm-7">
                                            <div class="{{ $errors->has('brand_image') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('brand_image') ? ' is-invalid' : '' }}" name="image" id="input-brand_image" type="file"/>
                                                @if ($errors->has('brand_image'))
                                                    <span id="brand_image-error" class="error text-danger" for="input-brand_image">{{ $errors->first('brand_image') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Add') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

                <div class="col-md-6">

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Available Brands') }}</h4>
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
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-danger">
                                            <th>
                                                Image
                                            </th>
                                            <th>
                                                Brand Name
                                            </th>
                                            <th>
                                                Edit
                                            </th>
                                            <th>
                                                Delete
                                            </th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @forelse($brands as $brand)

                                                    <td>
                                                        <img width="100px" src="{{ asset($brand->image) }}" alt="">
                                                    </td>

                                                    <td class="text-danger font-weight-bold">
                                                        {{ $brand->name }}
                                                    </td>

                                                    <td class="td-actions">
                                                        <a href="{{ route('brands.edit', $brand->id) }}"><i class="material-icons text-danger">edit</i></a>
                                                    </td>

                                                    <td class="td-actions">

                                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button onclick="return confirm('Are you sure?')" rel="tooltip" class="btn btn-success btn-link"
                                                                    data-original-title="" title="Delete">
                                                                <i class="material-icons text-danger">delete</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        </form>
                                                    </td>

                                            </tr>

                                            @empty

                                            @endforelse



                                            </tbody>
                                        </table>
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
