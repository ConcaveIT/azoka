@extends('layouts.app', ['activePage' => 'coupon', 'titlePage' => __('Create Coupon')])

@can('access-all-data')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{ route('coupon.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Create Coupon') }}</h4>
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
                                        <label class="col-sm-2 col-form-label">{{ __('Coupon Code') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group{{ $errors->has('sale_percentage') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="code" id="input-percentage" type="text" placeholder="{{ __('Coupon Code') }}" value="" required="true" aria-required="true"/>
                                                @if ($errors->has('percentage'))
                                                    <span id="percentage-error" class="error text-danger" for="input-sale_percentage">{{ $errors->first('percentage') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Coupon Value') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('sale_percentage') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="value" id="input-percentage" type="number" placeholder="{{ __('Sale Percentage') }}" value="" required="true" aria-required="true"/>
                                            @if ($errors->has('percentage'))
                                                <span id="percentage-error" class="error text-danger" for="input-sale_percentage">{{ $errors->first('percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

{{--                                    <input type="hidden" name="product_id" value="{{ $productId }}">--}}

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Expiry Date') }}</label>
                                    <div class="col-sm-7">
                                        <div class="{{ $errors->has('sale_expire') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('sale_expire') ? ' is-invalid' : '' }}" name="expire" id="input-sale_expire" type="date"/>
                                            @if ($errors->has('sale_expire'))
                                                <span id="sale_expire-error" class="error text-danger" for="input-sale_expire">{{ $errors->first('sale_expire') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-danger">{{ __('Create Coupon') }}</button>
                            </div>

                        </div>


                    </form>
                </div>

                <div class="col-md-6">

                    <div class="card ">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">{{ __('Available Coupons') }}</h4>
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
                                        Coupon
                                    </th>
                                    <th>
                                        Value
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
                                        @forelse($coupons as $coupon)

                                            <td>
                                                {{ $coupon->code }}
                                            </td>

                                            <td class="text-danger font-weight-bold">
                                                {{ $coupon->value }}
                                            </td>

                                            <td class="text-danger font-weight-bold">
                                                {{ $coupon->expire }}
                                            </td>

                                            <td class="td-actions">
                                                <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST">
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
