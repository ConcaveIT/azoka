@extends('layouts.app', ['activePage' => 'products', 'titlePage' => __('Products List')])

@canany(['access-all-data', 'access-admin-data', 'access-manager-data'])
@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title ">Products List</h4>
                            <p class="card-category"> Here you can manage products</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-left">
                                    <a href="{{ route('exportCSV') }}" class="btn btn-sm btn-danger">Export CSV</a>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-danger">Add Product</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="productsTable">
                                    <thead class=" text-danger">
                                    <tr>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Color
                                        </th>
                                        <th>
                                            Size
                                        </th>
                                        <th>
                                            Brand
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Sub Category
                                        </th>
                                        <th class="">
                                            Price
                                        </th>
                                        <th class="">
                                            Discount
                                        </th>
                                        <th class="">
                                            Edit
                                        </th>
                                        <th class="">
                                            Delete
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($products as $product)
                                        <tr class="">
                                            <td>
                                                <img width="100px" src="{{ asset($product->image_primary) }}" alt="">
                                            </td>
                                            <td>
                                                <a class="text-danger" href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                            </td>
                                            <td>
                                                @forelse($product->colors as $color)
                                                    <span class="p-2 mr-1" style="background-color: {{ $color->name }}"></span>
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse($product->sizes as $size)
                                                    <span class="p-2">{{ $size->name }}</span>
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>
                                                {{ $product->brand->name }}
                                            </td>
                                            <td>
                                                {{ $product->category->name }}
                                            </td>
                                            <td>
                                                {{ $product->sub_category->name }}
                                            </td>
                                            <td class="text-danger">
                                                {{ $product->price }}
                                            </td>
                                            <td class="text-danger">
                                                {{ $product->discount }}
                                            </td>

                                            <td class="td-actions">
                                                <a href="{{ route('products.edit', $product->id) }}"><i class="material-icons text-danger">edit</i></a>
                                            </td>
                                            <td class="td-actions text-right">
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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

