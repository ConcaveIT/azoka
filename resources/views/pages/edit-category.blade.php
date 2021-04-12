@extends('layouts.app', ['activePage' => 'category', 'titlePage' => __('Edit Category')])

@canany(['access-all-data', 'access-admin-data'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('categories.update', $category->id) }}" autocomplete="on" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Edit Category') }}</h4>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Category Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text"
                                                   placeholder="{{ __('Category Name') }}" value="{{ $category->name }}" required="true" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Category Image') }}</label>
                                        <div class="col-sm-7">
                                            <div class="{{ $errors->has('category_image') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('category_image') ? ' is-invalid' : '' }}" name="image" id="input-category_image" type="file"/>
                                                <img src="{{ asset($category->image) }}" width="100px" alt="">
                                                @if ($errors->has('category_image'))
                                                    <span id="category_image-error" class="error text-danger" for="input-category_image">{{ $errors->first('category_image') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Update') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

{{--                <div class="col-md-6">--}}

{{--                        <div class="card ">--}}
{{--                            <div class="card-header card-header-danger">--}}
{{--                                <h4 class="card-title">{{ __('Available Categories') }}</h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body ">--}}
{{--                                @if (session('status'))--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="alert alert-success">--}}
{{--                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                                    <i class="material-icons">close</i>--}}
{{--                                                </button>--}}
{{--                                                <span>{{ session('status') }}</span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table">--}}
{{--                                            <thead class=" text-danger">--}}
{{--                                            <th>--}}
{{--                                                Image--}}
{{--                                            </th>--}}
{{--                                            <th>--}}
{{--                                                Category Name--}}
{{--                                            </th>--}}
{{--                                            <th>--}}
{{--                                                Edit--}}
{{--                                            </th>--}}
{{--                                            <th>--}}
{{--                                                Delete--}}
{{--                                            </th>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                @forelse($categories as $category)--}}

{{--                                                    <td>--}}
{{--                                                        <img width="100px" src="{{ asset($category->image) }}" alt="">--}}
{{--                                                    </td>--}}

{{--                                                    <td class="text-success font-weight-bold">--}}
{{--                                                        {{ $category->name }}--}}
{{--                                                    </td>--}}

{{--                                                    <td class="td-actions">--}}
{{--                                                        <a href="{{ route('categories.edit', $category->id) }}"><i class="material-icons">edit</i></a>--}}
{{--                                                    </td>--}}

{{--                                                    <td class="td-actions">--}}

{{--                                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('DELETE')--}}
{{--                                                            <button onclick="return confirm('Are you sure?')" rel="tooltip" class="btn btn-success btn-link"--}}
{{--                                                                    data-original-title="" title="Delete">--}}
{{--                                                                <i class="material-icons">delete</i>--}}
{{--                                                                <div class="ripple-container"></div>--}}
{{--                                                            </button>--}}
{{--                                                        </form>--}}
{{--                                                    </td>--}}

{{--                                            </tr>--}}

{{--                                            @empty--}}

{{--                                            @endforelse--}}



{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}

{{--                            </div>--}}


{{--                        </div>--}}
{{--                </div>--}}


            </div>
        </div>

    </div>
    </div>
@endsection

@endcanany
