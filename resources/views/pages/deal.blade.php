@extends('layouts.app', ['activePage' => 'deal', 'titlePage' => __('Give Deal')])

@can('access-all-data')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('deal.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Give Deal') }}</h4>
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

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Deal Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('deal_percentage') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="price" id="input-percentage" type="number" placeholder="{{ __('Deal Price') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('percentage'))
                                                <span id="percentage-error" class="error text-danger" for="input-deal_percentage">{{ $errors->first('percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

{{--                                    <input type="hidden" name="product_id" value="{{ $productId }}">--}}

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Expiry Date') }}</label>
                                    <div class="col-sm-7">
                                        <div class="{{ $errors->has('deal_expire') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('deal_expire') ? ' is-invalid' : '' }}" name="expire" id="input-deal_expire" type="date"/>
                                            @if ($errors->has('deal_expire'))
                                                <span id="deal_expire-error" class="error text-danger" for="input-deal_expire">{{ $errors->first('deal_expire') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Give Deal') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

                <div class="col-md-6">

                    <div class="card ">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">{{ __('Available Deals') }}</h4>
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
                                        Deal Price
                                    </th>
                                    <th>
                                        Expiry Date
                                    </th>
                                    <th>
                                        Delete
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @forelse($deals as $deal)

                                            <td>
                                                {{ $deal->product->name }}
                                            </td>

                                            <td class="text-danger font-weight-bold">
                                                {{ $deal->price }}
                                            </td>

                                            <td class="text-danger font-weight-bold">
                                                {{ $deal->expire }}
                                            </td>

                                            <td class="td-actions">
                                                <form action="{{ route('deal.destroy', $deal->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')" rel="tooltip" class="btn btn-danger btn-link"
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
@endcan
