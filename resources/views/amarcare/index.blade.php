@extends('layouts.app', ['activePage' => 'amar-care', 'titlePage' => __('Amar Care')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Amar Care</h4>
                            <p class="card-category"> Post Vlog about self care</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('amar-care.create') }}" class="btn btn-sm btn-danger">New Vlog</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-danger">
                                    <tr>
                                        <th>
                                            Thumbnail
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($amarcares as $amarcare)
                                        <tr class="">
                                            <td>
                                                <img width="200px" src="http://img.youtube.com/vi/{{ $amarcare->video }}/mqdefault.jpg" alt="">
                                            </td>
                                            <td>
                                                <a class="text-danger" href="{{ route('amar-care.show', $amarcare->id) }}">{{ $amarcare->title }}</a>
                                            </td>
                                            <td>
                                                <a class="text-danger" href="{">{{ $amarcare->category->name }}</a>
                                            </td>
                                            <td>
                                                {!! $amarcare->description ? \Illuminate\Support\Str::limit($amarcare->description, 200, ' . . . ') : '' !!}
                                            </td>
                                            <td class="td-actions">
                                                <a href="{{ route('amar-care.edit', $amarcare->id) }}"><i class="material-icons text-danger">edit</i></a>
                                            </td>
                                            <td class="td-actions text-right">
                                                <form action="{{ route('amar-care.destroy', $amarcare->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')" rel="tooltip" class="btn btn-success btn-link"
                                                            data-original-title="" title="">
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

@endsection
@endcanany

