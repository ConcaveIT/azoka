@extends('layout.main', ['activePage' => 'featured-products', 'titlePage' => __('Featured Product')])

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
                                    <label class="col-sm-4 col-form-label">{{ __('Product') }}</label>
                                    <div class="col-sm-8">
                                        <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                            <div class="inline-block relative w-64 myseachselect">
                                                <select data-live-search="true" name="product_id" class="selectpicker">
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
                                        @forelse($featuredProducts as $product)

                                            <td>
                                                {{ $product->name }}
                                            </td>

                                            <td class="td-actions">
                                                <form action="{{ route('featured.destroy', $product->id) }}" method="POST">
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

