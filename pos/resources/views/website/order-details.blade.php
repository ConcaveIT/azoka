@extends('layout.main', ['activePage' => 'order', 'titlePage' => __('Order Details')])

@php
    // var_dump($order);
@endphp

<style>
.products_details ul li strong{
    padding-right: 10px;
}  
.products_details ul{
    margin-top: -22px;
}
.my_ol_class{
    padding: 0;
}  
.products_details{
    border: 1px solid #eaeaea;
    margin-bottom: 15px;    
}


</style>
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Order Details</h4>
                            <a href="{{ route('generate.invoice', $order->id) }}" style="float: right; margin-top: -25px;"> <button class="btn btn-info site_btn">Generate Invoice</button></a>
                            <p class="card-category"> Details of the order</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Order Id') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->id }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->created_at }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Order Type') }}</label>
                                <div class="col-sm-7">
                                    {{ strtoupper($order->type) }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Customer') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->name }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Phone Number') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->phone }}
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->email }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Products') }}</label>
                                <div class="col-sm-7">
                                    <ol class="my_ol_class">

                                        @forelse($order->order_details as $data)
                                            <li class="products_details">
                                                <ul>
                                                    @php
                                                        $color  = DB::table('product_variants')->find($data->color_id);
                                                        $size   = DB::table('product_variants')->find($data->size_id);
                                                        $weight = DB::table('product_variants')->find($data->weight_id);
                                                        $type   = DB::table('product_variants')->find($data->type_id);
                                                    @endphp


                                                    <li><strong>Name: </strong> {{ $data->product->name }}</li>
                                                    @if($size)
                                                        @php
                                                            
                                                        @endphp
                                                        <li> <strong>Size: </strong> {{ $size ? $size->variant_name : '' }}</li>
                                                    @endif

                                                    @if($color)
                                                        <li> <strong>Color: </strong> {{ $color ? $color->variant_name : '' }}</li>
                                                    @endif
                                                    @if($weight)
                                                        <li> <strong>Weight: </strong> {{ $weight ? $weight->variant_name : '' }}</li>
                                                    @endif
                                                    @if($type)
                                                        <li> <strong>Type: </strong> {{ $type ? $type->variant_name : '' }}</li>
                                                    @endif
                                                    @if($data->count)
                                                        <li> <strong>Qty: </strong> {{ $data->count }}</li>
                                                    @endif
                                                    @php
                                                       $original_price = price_after_offer_or_not($data->product->id, $data->product->price, $data->product->starting_date, $data->product->last_date);
                                                       $color_price  = $color->additional_price ?? 0;
                                                       $size_price   = $size->additional_price ?? 0;
                                                       $weight_price = $weight->additional_price ?? 0;
                                                       $type_price   = $type->additional_price ?? 0;
                                                   @endphp
                                                    <li> <strong>Price: </strong> {{ ($original_price+$color_price+$size_price+$weight_price+$type_price)*$data->count }}</li>
                                                </ul>
                                            </li>
                                        @empty
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Total Products') }}</label>
                                <div class="col-sm-7"> 
                                    {{ $order->order_details()->sum('count') }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Total Amount') }}</label>
                                <div class="col-sm-7">BDT 
                                    {{ $order->amount }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Payment Status') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->status }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Delivery Status') }}</label>
                                <div class="col-sm-7">
                                    {{ $order->delivery_status }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Billing Address') }}</label>
                                <div class="col-sm-7">
                                    {{ str_replace('+', ', ', $order->address) }}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Shipping Address') }}</label>
                                <div class="col-sm-7">
                                    {{ str_replace('+', ', ', $order->shipping_address) }}
                                </div>
                            </div>

                        </div>
                    </div>

                    <form method="post" action="" class="form-horizontal">
                        @csrf
                        @method('patch')

                        <label class="" for="input-notes">{{ __('Order Notes') }}</label>

                    <div class="row">

                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('noted') ? ' has-danger' : '' }}">
                                <textarea class="w-100" name="notes" id="" cols="" rows="10">{{ $order->notes }}</textarea>
                                @if ($errors->has('notes'))
                                    <span id="notes-error" class="error text-danger" for="input-product_notes">{{ $errors->first('notes') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                        <div class="card-footer ml-auto mr-auto p-5">
                            <input {!! $order->delivery_status == 'Shipped' ? 'checked' : '' !!} type="checkbox" name="delivery_status"> SHIP ORDER
                            <br>
                            <input {!! $order->status == 'Confirmed' ? 'checked' : '' !!} class="mt-5" type="checkbox" name="payment_status"> CONFIRM PAYMENT
                        </div>

                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-danger">{{ __('Update Order') }}</button>
                        </div>

                    </form>

                </div>




        </div>
    </div>
@endsection
