@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Order List')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Orders</h4>
                            <p class="card-category"> Here is a list of the orders</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-danger">
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
                                        Details
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @forelse($orders as $order)

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
                                            <a class="btn btn-danger" href="{{ route('order-details', $order->id) }}">Details</a>
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


{{--                <div class="col-md-12">--}}
{{--                    <div class="card card-plain">--}}
{{--                        <div class="card-header card-header-danger">--}}
{{--                            <h4 class="card-title mt-0"> Table on Plain Background</h4>--}}
{{--                            <p class="card-category"> Here is a subtitle for this table</p>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table table-hover">--}}
{{--                                    <thead class="">--}}
{{--                                    <th>--}}
{{--                                        ID--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        Name--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        Country--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        City--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        Salary--}}
{{--                                    </th>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            1--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Dakota Rice--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Niger--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Oud-Turnhout--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $36,738--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            2--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Minerva Hooper--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Curaçao--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Sinaai-Waas--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $23,789--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            3--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Sage Rodriguez--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Netherlands--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Baileux--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $56,142--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            4--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Philip Chaney--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Korea, South--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Overland Park--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $38,735--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            5--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Doris Greene--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Malawi--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Feldkirchen in Kärnten--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $63,542--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            6--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Mason Porter--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Chile--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            Gloucester--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            $78,615--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
