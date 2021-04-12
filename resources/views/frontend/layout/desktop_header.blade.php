<style>
 .mini_cart {
    padding: 0px !important;
    top: 155%;
}    
.table-responsive table thead {
    background: #fff;
}
.mysubtotal{
    padding: 5px 25px 0px 25px;
 }
 .cart_button a {
    color: #fff !important;
}
.cart_total span {
    font-size: 19px;
}

.mini_cart {
    height: unset !important;
}
.main_header {
    padding: 0px 0;
}
@media only screen and (max-width: 767px){ 
.mini_cart {
    right: -60px !important;
}
}
.offcanvas_menu_wrapper {
    width: 95%;
}
.language_currency{
    color:#fff;
}
</style>
<header>
    <div class="main_header">
        <div class="header_top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="language_currency top_left">
                            <ul>


                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="language_currency text-right">
                            <ul>
                                @php
                                    $compare = \session()->get('compare') ?? [];
                                @endphp

                                <li><a href="{{ route('compare') }}"><i class="icon-refresh icons mr-1"></i> Compare (<span class="compareCount">{{ count($compare) }}</span>)</a></li>

                                @auth('customer')

                                <li><a href="{{ route('wishlist') }}"><i class="icon-heart mr-1"></i> Wishlist (<span class="wishlistCount">{{ auth()->guard('customer')->user()->wishlist->count() ?? ''  }}</span>)</a></li>

                                @elseguest('customer')
                                    <li><a href="{{ route('customer-login') }}"><i class="icon-heart mr-1"></i> Wishlist (0)</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="header_middle sticky-header">

            <nav class="navbar navbar-hover navbar-expand-lg navbar-soft">
                <div class="collapse navbar-collapse" id="main_nav99">
                    <ul class="navbar-nav flex flex-row items-center justify-evenly w-full">
                        <li class="nav-item">
                            <a href="{{ route('home') }}"><img width="150px" src="{{ logo($general_setting->site_logo) }}" alt=""></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> Shop </a>
                            <ul class="dropdown-menu">
                                @forelse(\App\Category::all() as $category)
                                    <li class="has-megasubmenu">
                                        <a class="dropdown-item" href="{{ route('shop', $category->slug) }}"> {{ $category->name }} </a>
                                    </li>
                                @empty
                                <p> No categery found.</p>
                                @endforelse

                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="/about-us"> About Us </a></li>
                        <li class="nav-item"><a class="nav-link" href="/contact-us"> Contact Us </a></li>

                        @auth('customer')

                            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#"><i class="fa fa-user"></i></a>
                                <ul class="dropdown-menu animate fade-up">

                                    <li class=""><a class="dropdown-item" href="{{ route('my-account') }}">My Account <i class=""></i></a></li>

                                    <li class=""><a class="dropdown-item" href="{{ route('logout_customer') }}">Logout <i class=""></i></a></li>
                                </ul>
                            </li>


                        @elseguest('customer')
                            <li class="nav-link"><a class="nav-link" href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                        @endauth

                        <div class="col-md-2 col-lg-2 col-sm-2 flex justify-center">
                            <div class="header_account_area">
                                <div class="header_account_list search_list">
                                    <a href="javascript:void(0)"><i id="searchIcon" class="icon-magnifier icons"></i></a>
                                    <div class="dropdown_search">
                                        <form action="{{ route('search') }}" method="GET">
                                            <input id="dropdown_search_input" placeholder="Search entire store here ..." type="text" name="search">
                                            <button type="submit"><i class="icon-magnifier icons"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="header_account_list  mini_cart_wrapper">
                                    <a href="javascript:void(0)"><i class="icon-bag icons"></i>
                                        <span class="cart_itemtotal cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>
                                        <span class="item_count cart_items_quantity">{{ session()->get('cart_items_quantity') ?? 0 }}</span>
                                    </a>
                                <div class="mini_cart">
                                    <div class=""> 
                                        <table class="table table-bordered table-hover" style="width: 100%;">
                                          <thead>
                                            <tr>
                                              <th style="width: 20%;">Image</th>
                                              <th style="width: 45%;">Name</th>
                                              <th style="width: 30%;">Price</th>
                                              <th style="width: 5%;">Delete</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach(session()->get('cart') ?? [] as $data)
                                                @php
                                                    $product = \App\Product::findOrFail($data['product_id']);
                                                    $color = DB::table('product_variants')->find($data['color_id']);
                                                    $size = DB::table('product_variants')->find($data['size_id']);
                                                    $type = DB::table('product_variants')->find($data['type_id']);
                                                    $weight = DB::table('product_variants')->find($data['weight_id']);
                                                @endphp
                                                <tr>
                                                    <th><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}"><img src="{{ productImage($product->image) }}" alt="" style='width=100px; height:auto;object-fit:contain;' ></a> </th>
                                                    <td><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">{{ $product->name }}</a></td>
                                                    <td>BDT {{ $cart_price = (price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0))*$data['count'] }}</td>
                                                    <td><a id="header_cart" data-cart-id="{{ $data['cart_id']}}"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                            @endforeach
                                          </tbody>
                                        </table>
                                    </div>
                                    <div class="mysubtotal">
                                        <div class="cart_total mb-3 pr-3 pl-3">
                                            <span><strong>Total:</strong></span>
                                            <span class="price cart_total_amount">BDT {{ session()->get('cart_sub_total') ? session()->get('cart_sub_total')  : 0 }}</span>
                                        </div>
                                        <div class="mini_cart_footer">
                                            <div class="cart_button">
                                                <a class="customButton text-white" href="{{ route('cart') }}"><i class="fa fa-shopping-cart text-white"></i> View cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                </div>
                            </div>
                        </div>


                    </ul>
                </div> <!-- navbar-collapse.// -->
            </nav>
        </div>
    </div>
</header>



