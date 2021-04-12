@extends('layouts.app', ['activePage' => 'featured-products', 'titlePage' => __('Featured Product')])

@canany(['access-all-data', 'access-manager-data'])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('featured.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Make Featured') }}</h4>
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
                                        <label class="col-sm-2 col-form-label">{{ __('Product') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                                <div class="inline-block relative w-64">
                                                    <select name="product_id" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                        @forelse($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                            <hr>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>

                                                @if ($errors->has('product_id'))
                                                    <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('product_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Make Featured') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

                <div class="col-md-6">

                    <div class="card ">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">{{ __('Featured Products') }}</h4>
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
                                        Product
                                    </th>
                                    <th>
                                        Remove
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @forelse($featureds as $featured)

                                            <td>
                                                {{ $featured->product ? $featured->product->name : '' }}
                                            </td>

                                            <td class="td-actions">
                                                <form action="{{ route('featured.destroy', $featured->id) }}" method="POST">
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
