<!--offcanvas menu area start-->
<div class="off_canvars_overlay">
<style>

.mobile_logo {
    position: absolute;
    top: 28px;
    z-index: 99;
}

.mobile_search_icon{
    position: absolute;
    right: 70px;
    top: 28px;
}
.mobile_search_icon a {
    border: 1px solid #383232;
    padding: 5px;
    font-size: 19px;
}

.main_header {
    padding: 20px 0;
}

.mobile_haders{
    height: 70px;
    position: fixed;
    width: 100%;
    top: -12px;
    z-index: 9;
    background: #fcfcfc;
}
.mini_cart_table {
    padding: unset;
}

.mini_cart {
width: 100%;
top:0;
}   
@media(max-width:767px){
    .table-responsive {
    overflow-x: scroll;
}
} 
@media only screen and (max-width: 767px){ 
.mini_cart {
    right: -60px !important;
}
}
.offcanvas_menu_wrapper {
    width: 95%;
}
.offcanvas_menu_wrapper {
    margin-left: -100%;
}
.language_currency{
    color:#000;
}


@media only screen and (max-width: 767px){ 
.language_currency > ul > li > a {
    color: #000 !important;
}
}

<style>
   .search_for{
       font-size: 20px;
       line-height: 35px;
       color: #000;
       padding-top: 55px;
       padding-bottom: 15px;
   } 

   .header_account_list .search_list{
       text-align: right;
   }
   @media only screen and (max-width: 767px){
    .dropdown_search {
        top: 34px;
        width: 290px;
        left: -208px;
    }
   }
</style>
</div>
<div class="offcanvas_menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row mobile_haders">
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6">
                        <div class="mobile_logo">
                            <a href="{{ route('home') }}"><img width="200px" src="{{ logo($general_setting->site_logo) }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-6 col-xs-6 col-sm-6 col-md-6">
                        <div class="mobile_search_icon">
                            <a id="searchIcon" href="javascript:void(0)"><i class="icon-magnifier icons"></i></a>
                            <div class="dropdown_search">
                                <form action="{{ route('search') }}" method="GET">
                                    <input placeholder="Search entire store here ..." type="text" name="search">
                                    <button type="submit"><i class="icon-magnifier icons"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="canvas_open">
                            <a href="javascript:void(0)"><i class="icon-menu"></i></a>
                        </div>
                    </div>
                </div>
                <div class="offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>

                    <div class="language_currency bottom">
                        <ul>
                            @php
                                $compare = \session()->get('compare') ?? [];
                            @endphp

                            <li><a href="{{ route('compare') }}"><i class="icon-refresh icons mr-1"></i> Compare (<span class="compareCount">{{ count($compare) }}</span>)</a></li>

                            @auth('customer')

                                <li><a href="{{ route('wishlist') }}"><i class="icon-heart mr-1"></i> Wishlist (<span class="wishlistCount">{{ auth()->guard('customer')->user()->wishlist->count()  }}</span>)</a></li>

                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}"><i class="icon-heart mr-1"></i> Wishlist (0)</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="header_account_area">
                        <div class="header_account_list search_list">
                            <div class="mymobile_search">
                                <a href="javascript:void(0)"><i class="icon-magnifier icons"></i></a>
                                <div class="dropdown_search">
                                    <form action="{{ route('search') }}" method="GET">
                                        <input placeholder="Search entire store here ..." type="text" name="search">
                                        <button type="submit"><i class="icon-magnifier icons"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="header_account_list  mini_cart_wrapper">
                            <a href="javascript:void(0)"><i class="icon-bag icons"></i>
                                <span class="cart_itemtext">Cart:</span>
                                <span class="cart_itemtotal cart_sub_total">BDT {{ session()->get('cart_sub_total') ?? 0 }}</span>
                                <span class="item_count cart_items_quantity">{{ session()->get('cart_items_quantity') ?? 0 }}</span>
                            </a>
                            <!--mini cart-->
                            <div class="mini_cart">
                                <div class="mini_cart_table">
                                    <div class="table-responsive"> 
                                        <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Delete</th>
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
                                                    <td><a href="{{ route('product-details', [$product->category->slug, $product->slug]) }}">{{ $product->name }}</a></td>
                                                    <td>BDT {{ $cart_price = price_after_offer_or_not($product->id, $product->price, $product->starting_date, $product->last_date) + ($color ? $color->additional_price : 0) + ($size ? $size->additional_price : 0) + ($type ? $type->additional_price : 0) + ($weight ? $weight->additional_price : 0) }}</td>
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
                            <!--mini cart end-->
                        </div>
                    </div>

                    <div id="menu" class="text-left ">
                        <ul class="offcanvas_main_menu">
                            <li class=" active">
                                <a href="/">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Shop</a>
                                <ul class="sub-menu">
                                    @php
                                        $categories = \App\Category::all();
                                    @endphp
                                    @forelse($categories as $category)
                                        <li class="menu-item-has-children"><a href="{{ route('shop', $category->slug) }}">{{ $category->name }}</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </li>


                            <li><a href="/about-us"> About us</a></li>
                            <li><a href="/contact-us"> Contact Us</a></li>
                            @auth('customer')
                                <li class="menu-item-has-children">
                                    <a href="#"><i class="fa fa-user"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('my-account') }}">My Account</a></li>
                                        <li><a href="{{ route('logout_customer') }}">Log Out</a></li>

                                    </ul>
                                </li>
                            @elseguest('customer')
                                <li><a href="{{ route('customer-login') }}">Login <i class=""></i></a></li>
                            @endauth

                        </ul>
                    </div>
                    <div class="offcanvas_footer">
                        <span><a href="mailto:azoka.bd2020@gmail.com"><i class="fa fa-envelope-o"></i> info@azoka.com.bd</a></span>
                        <br>
                        <span><a href="mailto:inf0@azoka.com.bd"><i class="fa fa-envelope-o"></i> info@azoka.com.bd</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--offcanvas menu area end-->
