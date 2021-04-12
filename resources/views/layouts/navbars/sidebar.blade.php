<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      {{ __('Amar Shop') }}
    </a>
  </div>
  <div class="sidebar-wrapper">

    <ul class="nav">

        @canany(['access-all-data', 'access-admin-data',])


        <li class="nav-item{{ $activePage == 'amar-care' ? ' active' : '' }}">
            <a class="nav-link" href="/admin/amar-care">
                <i class="fa fa-heart"></i>
                <p>{{ __('Amar Care') }}</p>
            </a>
        </li>
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'users') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="fa fa-user"></i>
          <p>{{ __('Users') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse " id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('users.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item{{ $activePage == 'customers' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('customers') }}">
          <i class="material-icons">people</i>
            <p>{{ __('Customers') }}</p>
        </a>
      </li>

        @endcanany

        <li class="nav-item{{ $activePage == 'orders' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('orders') }}">
                <i class="material-icons">assignment</i>
                <p>{{ __('Orders') }}</p>
            </a>
        </li>

            @canany(['access-all-data', 'access-admin-data'])

        <li class="nav-item {{ ($activePage == 'category' || $activePage == 'sub_category') ? ' ' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#category" aria-expanded="true">
                <i class="fa fa-book"></i>
                <p>{{ __('Categories') }}
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse" id="category">
                <ul class="nav">
                    <li class="nav-item{{ $activePage == 'category' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <span class="sidebar-mini"> C </span>
                            <span class="sidebar-normal">{{ __('Category') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'sub_category' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('sub_categories.index') }}">
                            <span class="sidebar-mini"> SC </span>
                            <span class="sidebar-normal"> {{ __('Sub Category') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

            @endcanany

        <li class="nav-item {{ ($activePage == 'products' || $activePage == 'add-product') ? ' active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="true">
                <i class="fa fa-product-hunt"></i>
                <p>{{ __('Products') }}
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse" id="products">
                <ul class="nav">
                    <li class="nav-item{{ $activePage == 'products' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <span class="sidebar-mini"> PL </span>
                            <span class="sidebar-normal">{{ __('Product List') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'add-product' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('products.create') }}">
                            <span class="sidebar-mini"> AP </span>
                            <span class="sidebar-normal"> {{ __('Add Product') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'featured-product' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('featured.index') }}">
                            <span class="sidebar-mini"> FP </span>
                            <span class="sidebar-normal"> {{ __('Featured Product') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

            @canany(['access-all-data', 'access-admin-data'])

      <li class="nav-item{{ $activePage == 'sale' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('sale.index') }}">
          <i class="material-icons">%</i>
            <p>{{ __('Sale') }}</p>
        </a>
      </li>

        <li class="nav-item{{ $activePage == 'deal' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('deal.index') }}">
                <i class="material-icons">%</i>
                <p>{{ __('Deal') }}</p>
            </a>
        </li>

      <li class="nav-item{{ $activePage == 'coupon' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('coupon.index') }}">
          <i class="material-icons">redeem</i>
          <p>{{ __('Coupon') }}</p>
        </a>
      </li>

        <li class="nav-item{{ $activePage == 'slider' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('slider') }}">
                <i class="material-icons">view_carousel</i>
                <p>{{ __('Slider') }}</p>
            </a>
        </li>

        <li class="nav-item{{ $activePage == 'brand' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('brands.index') }}">
                <i class="material-icons">work</i>
                <p>{{ __('Brands') }}</p>
            </a>
        </li>

        <li class="nav-item {{ ($activePage == 'page-manager') ? ' active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#pageManager" aria-expanded="true">
                <i class="material-icons">pages</i>
                <p>{{ __('Page Manager') }}
                    <b class="caret"></b>
                </p>
            </a>
            <div class="collapse " id="pageManager">
                <ul class="nav">
                    <li class="nav-item{{ $activePage == 'customer-care' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('customer-care') }}">
                            <span class="sidebar-mini"> CC </span>
                            <span class="sidebar-normal">{{ __('Customer Care') }} </span>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'policies' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('policies') }}">
                            <span class="sidebar-mini"> P </span>
                            <span class="sidebar-normal"> {{ __('Policies') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item{{ $activePage == 'testimonial' ? ' active' : '' }}">
            <a class="nav-link" href="/admin/testimonial">
                <i class="material-icons">pending</i>
                <p>{{ __('Testimonial') }}</p>
            </a>
        </li>

            @endcanany


    </ul>
  </div>
</div>
