@extends('layout.main', ['activePage' => 'deal', 'titlePage' => __('Give Deal')])
<style>
.btn-group {
    width: 100% !important;
}
.selectpicker{
    outline: 0;
} 
.myseachselect{
    margin-bottom: 15px;
    border: 1px solid #e4e4e4;
}

.card-body .row{
    margin-bottom: 15px;
}
</style>

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <form method="post" action="{{ route('deals.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">{{ __('Give Deal') }}</h4>
                            </div>
                            <div class="card-body">
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
                                    <label class="col-sm-3 col-form-label">{{ __('Product') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                            <div class="inline-block relative w-64 myseachselect">

                                                @php
                                                    $deal_ids = [];
                                                    foreach(DB::table('deals')->get() as $deal){
                                                        $deal_ids[] = $deal->product_id;
                                                    }
                                                @endphp

                                                <select data-live-search="true" name="product_id" class="selectpicker" id='promotionalPrice'>
                                                    <option selected disabled>--Select Product--</option>
                                                    @forelse($products as $product)
                                                        @if(!in_array($product->id,$deal_ids))
                                                            <option value="{{$product->id}}">{!! $product->name !!}</option>
                                                            <hr>
                                                        @endif
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

                                



                            <div id="pricing_sectiont">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Deal Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('deal_percentage') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="price" id="input-percentage" type="number" placeholder="{{ __('Deal Price') }}" value="" aria-required="true" />
                                            <span>(For banner deal)</span>
                                            @if ($errors->has('percentage'))
                                                <span id="percentage-error" class="error text-danger" for="input-deal_percentage">{{ $errors->first('percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Deal Percentage') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('deal_percentage') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }}" name="percentage" id="input-percentage" type="number" placeholder="{{ __('Deal Percentage') }}" value=""  aria-required="true"/>
                                            <span>(For calender deal)</span>
                                            @if ($errors->has('percentage'))
                                                <span id="percentage-error" class="error text-danger" for="input-deal_percentage">{{ $errors->first('percentage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <script>
                                $(document).on('change', '#promotionalPrice', function(){
                                    var id = $(this).val();
                                    $.ajax({
                                        type: 'GET',
                                        url: '/check-promotional-price/'+id,
                                        success: function(data) {
                                            if(data == 1){
                                                $('#pricing_sectiont').hide();
                                            }else if(data == 0){
                                                $('#pricing_sectiont').show();
                                            }
                                        }
                                    });
                                });
                            </script>
                            <div class="row">
                                    <label class="col-sm-3 col-form-label">{{ __('Expiry Date') }}</label>
                                    <div class="col-sm-7">
                                        <div class="{{ $errors->has('deal_expire') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('deal_expire') ? ' is-invalid' : '' }}" name="expire" id="input-deal_expire" type="date" required/>
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

                <div class="col-md-5">

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
                                        Deal
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
                                                @if($deal->price)
                                                    {{ 'BDT '.$deal->price }}
                                                @else
                                                    {{ $deal->percentage . '%' }}
                                                @endif
                                            </td>

                                            <td class="text-danger font-weight-bold">
                                                {{ $deal->expire }}
                                            </td>

                                            <td class="td-actions">
                                                <form action="{{ route('deals.destroy', $deal->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')" rel="tooltip" class="btn btn-danger btn-link"
                                                            data-original-title="" title="Delete">
                                                        <i class="material-icons text-white">delete</i>
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

<script>
    $(document).ready(function(){
        $('.myseachselect select').selectpicker();
    });
</script>

