@extends('layouts.admin')

@section('content')
    <div class="mb-4 shadow card">
        <div class="py-3 card-header d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                Products
            </h6>
            <div class="ml-auto">
                @can('create_category')
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                        <span class="text">New product</span>
                    </a>
                @endcan
            </div>
        </div>

        @include('partials.backend.filter', ['model' => route('admin.products.index')])

        <div class="table-responsive">
            <table class="table table-hover" id="table-1">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a></td>
                        <td>
                            @foreach($product->productCountries as $productCountry)
                                <span>{{$productCountry->country->short_name}}: {{ number_format($productCountry->quantity)  }}</span><br/>
                            @endforeach
                        </td>
                        <td>
                            @foreach($product->productCountries as $productCountry)
                                <span>{{$productCountry->country->short_name}}: {{ number_format($productCountry->price)  }} XAF</span><br/>
                            @endforeach
                        </td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   onclick="if (confirm('Are you sure to delete this record?'))
                                       {document.getElementById('delete-product-{{ $product->id }}').submit();} else {return false;}"
                                   class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  id="delete-product-{{ $product->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="10">No products found.</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">
                            {!! $products->appends(request()->all())->links() !!}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
