@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <div class="container-fluid">
        @if(in_array("returns-add", $all_permission))
            <a href="{{route('damage-sale.create')}}" class="btn btn-info"><i class="dripicons-plus"></i>Add Damged Good</a>
        @endif
    </div><br>
    <div class="table-responsive container-fluid">
        <table id="damage-table" class="table damage-list">
            <thead>
                <tr>
					<th>Serial</th>
					<th>Date</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Quantity</th>
                    <th>Note</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_return_all  as $key=>$damage)
                <tr>
					<td>{{$key+1}}</td>
                    <td>{{ date($general_setting->date_format, strtotime($damage->created_at->toDateString())) . ' '. $damage->created_at->toTimeString() }}</td>
                    <td>{{ \DB::table('products')->where('id',$damage->product_id)->first()->name }}</td>
                    
					<td>
					
					{{ \DB::table('product_variants')->where('variant_id',$damage->variant_id)->first()->variant_name ?? 'N/A'}}
					
					</td>
					
                    <td>{{ $damage->qty }}</td>
                    <td>{{$damage->note}}</td>
					
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">

                                <li class="divider"></li>
                                {{ Form::open(['route' => ['damage-sale.destroy', $damage->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="damage confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>

@endsection('content')
