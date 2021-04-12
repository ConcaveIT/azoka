@extends('frontend.layout.master')

@section('header')

    @include('frontend.layout.header')

@endsection

@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list">
                                <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                                <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                                <li><a href="#address" data-toggle="tab" class="nav-link">Address</a></li>
                                <li><a href="#account-details" data-toggle="tab" class="nav-link">Account details</a></li>
                                <li><a href="{{ route('logout_customer') }}" class="nav-link">logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="dashboard">
                                <h3>Dashboard </h3>
                                <p>From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a> and <a href="#">Edit your password and account details.</a></p>
                            </div>
                            <div class="tab-pane fade" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Product Name</th>
                                                <th>Date</th>
                                                <th>Delivery Status</th>
                                                <th>Total</th>
                                                <th>Order Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($customer->orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ get_product_name($order->id) }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td><span class="success">{{ $order->delivery_status }}</span></td>
                                                <td> BDT {{ $order->amount }} for {{ $order->order_details->sum('count') }} items</td>
                                                <td>
                                                {{ $order->status }}

                                                @if($order->status == 'Failed' || $order->status == 'Pending')
                                                    <form method="post" action="/pay-again">
                                                        @csrf
                                                        <input type="hidden" name="transaction_id" value="{{$order->transaction_id}}">
                                                        <button type="submit" class="customButton btn btn-success">Pay Now</button>
                                                    </form>
                                                @endif
                                                
                                                
                                                </td>

                                            </tr>

                                        @empty
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="address">
                               <p>The following addresses will be used on the checkout page by default.</p>
                                <div class="checkout_form">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                <h4 class="billing-address">Billing address</h4>
                                <div class="row">
                                    <form action="{{ route('update-address') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                    <div class="col-12 mb-5 pb-5">
                                        <label for="division">Division <span>*</span></label>
                                        <select class="select_option" name="state" id="division">

                                            <option value="{{ $customer->state ?? '' }}">{{ ucfirst($customer->state) ?? '' }}</option>

                                            <option value="dhaka">Dhaka</option>
                                            <option value="chittagong">Chittagong</option>
                                            <option value="barisal">Barisal</option>
                                            <option value="khulna">Khulna</option>
                                            <option value="mymensingh">Mymensingh</option>
                                            <option value="sylhet">Sylhet</option>
                                            <option value="rangpur">Rangpur</option>

                                        </select>
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>District <span>*</span></label>
                                        <input type="text" name="district" value="{{ $customer->district ?? '' }}">
                                    </div>

                                    <div class="col-12 mb-5">
                                        <label>Town / City <span>*</span></label>
                                        <input type="text" name="city" value="{{ $customer->city ?? '' }}">
                                    </div>

                                        <div class="col-12 mb-5">
                                            <label>Postal Code <span>*</span></label>
                                            <input type="text" name="postal_code" value="{{ $customer->postal_code ?? '' }}">
                                        </div>

                                    <div class="col-12 mb-5">
                                        <label>Street address  <span>*</span></label>
                                        <input name="address" placeholder="House number and street name" type="text" value="{{ $customer->address ?? '' }}">
                                    </div>

                                    <button class="customButton py-2 px-6" style="border-radius: 5px" type="submit">Save</button>

                                    </form>

                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form">
                                            <form action="{{ route('update-account') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <label>Name</label>
                                                <input type="text" name="name" value="{{ $customer->name }}">
                                                <label>Email</label>
                                                <input type="email" name="email" value="{{ $customer->email }}">
                                                @if ($errors->has('email'))
                                                    <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('email') }}</span>
                                                    <br>
                                                @endif
                                                <label>Phone Number</label>
                                                <input type="text" name="phone_number" value="{{ $customer->phone_number }}">
                                                <label>Password</label>
                                                <input type="password" name="password" required>
                                                <label>Birthdate</label>
                                                <input type="date" placeholder="MM/DD/YYYY" value="{{ $customer->birthdate }}" name="birthdate">
                                                <span class="example">
                                                  (E.g.: 05/31/1970)
                                                </span>
                                                <br>
                                                <span class="custom_checkbox">
                                                    <input {{ $customer->receive_offer ? 'checked' : '' }} type="checkbox" value="1" name="receive_offer">
                                                    <label>Receive offers from our partners</label>
                                                </span>
                                                <br>
                                                <span class="custom_checkbox">
                                                    <input {{ $customer->newsletter ? 'checked' : '' }} type="checkbox" value="1" name="newsletter">
                                                    <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>
                                                </span>
                                                <div class="save_button primary_btn default_button">
                                                   <button class="customButton py-2 px-6" style="border-radius: 5px" type="submit">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- my account end   -->

     <!--brand area start-->
@include('frontend.layout.brand')
    <!--brand area end-->

@endsection


@section('modal')

    @include('frontend.layout.modal')

@endsection

@section('footer')

    @include('frontend.layout.footer')

@endsection
