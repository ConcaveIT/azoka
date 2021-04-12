@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

@can('access-all-data')

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_copy</i>
              </div>
              <p class="card-category">Total Products</p>
              <h3 class="card-title">{{ \App\Product::count() }}
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-danger">product</i>
                <a class="text-danger" href="{{ route('products.index') }}">View</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Revenue</p>
              <h3 class="card-title">BDT {{ \App\Order::where('status', 'Confirmed')->get()->sum('amount') }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">product</i> <a class="text-danger" href="#">&nbsp;</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">info_outline</i>
              </div>
              <p class="card-category">Awaiting Shipment</p>
              <h3 class="card-title">{{ \App\Order::where('delivery_status', 'Awaiting')->count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">product</i>
                  <a class="text-danger" href="{{ route('orders') }}">View</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="fa fa-user"></i>
              </div>
              <p class="card-category">Customers</p>
              <h3 class="card-title">+{{ \App\Customer::count() }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">product</i> <a class="text-danger" href="{{ route('customers') }}">View</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
            </div>

          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Email Subscriptions</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>

          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Completed Orders</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>

          </div>
        </div>
      </div>


      <div class="row">

        <div class="col-lg-6 col-md-12">
          <div class="card" style="height: 500px; overflow: auto">
            <div class="card-header card-header-tabs card-header-danger">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Logs:</span>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <table class="table">
                    <tbody>
<<<<<<< HEAD

=======
                    {{--  @forelse($activities as $activity)

                      <tr>
                          <td>
                              {{ $activity->created_at }}
                          </td>
                        <td>{{ $activity->causer ? $activity->causer->name : '' }} has {{ $activity->description }} {{ class_basename($activity->subject_type) }} {{ $activity->subject->name ?? '' }}</td>
                        <td class="td-actions text-right">
{{--                          <a type="button" href="/admin/activities/{{ $activity->id }}" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">--}}
{{--                            <i class="material-icons">close</i>--}}
{{--                          </a>--}}
                     {{--    </td>
                      </tr>

                    @empty

                    @endforelse
--}}
>>>>>>> bee8348e8f3dabc30ff9bc30c88af0b5f3b7dc82
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-danger">
              <h4 class="card-title">Employees Stats</h4>
              <p class="card-category">New employees first</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <th>Name</th>
                  <th>Salary</th>
                  <th>Role</th>
                </thead>
                <tbody>
                  {{--
                @forelse($users as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>BDT 0</td>
                    <td>{{ ucfirst($user->roles[0]->name) }}</td>
                  </tr>
                @empty
                @endforelse
                --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>


@endcan

@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>

@endpush
