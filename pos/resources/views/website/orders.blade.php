@extends('layout.main', ['activePage' => 'orders', 'titlePage' => __('Order List')])
<style>
    .custom{
        padding: 3px 4px !important;
    font-size: 12px !important;
    color:#fff;
    margin-bottom: 5px;
    }
    
</style>
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Orders</h4>
                            <p class="card-category"> Here is a list of the orders</p>
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
                            @endif
                            @if(session()->has('not_permitted'))
                                <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="orders-table">
                                    <thead class=" text-danger">
                                    <tr>
                                    <th></th>

                                    <th>
                                        Order Id
                                    </th>
                                    <th>
                                        Order Type
                                    </th>
                                    <th>
                                        Customer
                                    </th>
                                    <th>
                                        Total Products
                                    </th>
                                    <th>
                                        Total Amount
                                    </th>
                                    <th>
                                        Payment Status
                                    </th>
                                    <th>
                                        Delivery Status
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Details
                                    </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($orders as $order)

                                        <tr>
                                        <td></td>

                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>
                                            {{ strtoupper($order->type) }}
                                        </td>
                                        <td>
                                            {{ $order->name }}
                                        </td>
                                        <td>
                                            {{ $order->order_details()->sum('count') }}
                                        </td>
                                        <td>
                                            {{ $order->amount }}
                                        </td>
                                        <td>
                                            {{ $order->status }}
                                        </td>

                                        <td>
                                            {{ $order->delivery_status }}
                                        </td>

                                        <td>
                                            {{  date('d M Y', strtotime($order->created_at)) }}
                                        </td>
                                        <td>
                                            
											@if($order->status == 'Canceled') 
										   <a onclick="return confirm('Are you sure to delete ?')" href="{{ route('order-delete', $order->id) }}" class="btn btn-danger custom">Delete</a>
											@endif
											
                                           @if($order->status != 'Canceled')
										   <a onclick="return confirm('Are you sure to cancel this order ?')" class="btn btn-warning custom" href="{{ route('order-cancel', $order->id) }}">Cancel</a>
											@endif
											
                                            <a class="btn btn-info custom" href="{{ route('order-details', $order->id) }}">Details</a> 
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

        <script>
            $('#orders-table').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            modifier: {
                                selected: null
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            modifier: {
                                selected: null
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            modifier: {
                                selected: null
                            }
                        }
                    }
                ],

                'select': {
                    style: 'multi'
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    },
                    {
                        'render': function(data, type, row, meta){
                            if(type === 'display'){
                                data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                            }

                            return data;
                        },
                        'checkboxes': {
                            'selectRow': true,
                            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                        },
                        'targets': [0]
                    }
                ],
                "language": {
                    "lengthMenu": "_MENU_ records per page"
                },
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                "lengthChange": true ,
                "aaSorting": [[1,'desc']],

            });
        </script>



<script>
    $(document).on('click', '#delete_order', function(){
        
    });
</script>
@endsection
