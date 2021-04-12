@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('User Manager')])

@can('access-all-data')

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Users</h4>
                            <p class="card-category"> Here you can manage users</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-danger">Add user</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-danger">
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Creation date
                                        </th>
                                        <th class="text-right">
                                            Actions
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->created_at }}
                                        </td>
                                        <td class="td-actions text-right">
                                            <a rel="tooltip" href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-link"
                                                    data-original-title="" title="Edit">
                                                <i class="material-icons text-danger">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button rel="tooltip" class="btn btn-danger btn-link"
                                                   data-original-title="" title="Delete" onclick="return confirm('Are you sure?')">
                                                    <i class="material-icons">delete</i>
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

@endsection

@endcan

