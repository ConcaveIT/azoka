@extends('layouts.app', ['activePage' => 'sub_category', 'titlePage' => __('Edit Sub Category')])

@canany(['access-all-data', 'access-admin-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('sub_categories.update', $sub_category->id) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Edit Sub Category') }}</h4>
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
                                        <label class="col-sm-2 col-form-label">{{ __('Category') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="category_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($categories as $category)
                                                            <option {{ $category->id == $sub_category->category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Sub Category Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text"
                                                   placeholder="{{ __('Sub Category Name') }}" value="{{ $sub_category->name }}" required="true" aria-required="true"/>
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Sub Category Image') }}</label>
                                        <div class="col-sm-7">
                                            <div class="{{ $errors->has('category_image') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('category_image') ? ' is-invalid' : '' }}" name="image" id="input-category_image" type="file"/>
                                                <img src="{{ asset($sub_category->image) }}" width="100px" alt="">
                                                @if ($errors->has('category_image'))
                                                    <span id="category_image-error" class="error text-danger" for="input-category_image">{{ $errors->first('category_image') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Edit') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

{{--                <div class="col-md-6">--}}

{{--                        <div class="card ">--}}
{{--                            <div class="card-header card-header-danger">--}}
{{--                                <h4 class="card-title">{{ __('Available Sub Categories') }}</h4>--}}
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
{{--                                                Category--}}
{{--                                            </th>--}}
{{--                                            <th>--}}
{{--                                                Sub Category--}}
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
{{--                                                @forelse($sub_categories as $sub_category)--}}

{{--                                                    <td>--}}
{{--                                                        <img width="100px" src="{{ asset($sub_category->image) }}" alt="">--}}
{{--                                                    </td>--}}

{{--                                                    <td class="text-success font-weight-bold">--}}
{{--                                                        {{ $sub_category->category->name }}--}}
{{--                                                    </td>--}}

{{--                                                    <td class="text-success font-weight-bold">--}}
{{--                                                        {{ $sub_category->name }}--}}
{{--                                                    </td>--}}

{{--                                                <td class="td-actions">--}}
{{--                                                    <a href="{{ route('sub_categories.edit', $sub_category->id) }}"><i class="material-icons">edit</i></a>--}}
{{--                                                </td>--}}

{{--                                                    <td class="td-actions">--}}
{{--                                                        <form action="{{ route('sub_categories.destroy', $sub_category->id) }}" method="POST">--}}
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
