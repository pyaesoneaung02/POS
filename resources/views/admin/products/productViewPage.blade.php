@extends('admin.layouts.master')
@section('title', 'product view')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <a href="{{ route('adminDashboard') }}" class="ml-3 btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i>
        Back</a>
    <div class=" row">
        <div class="col-10 offset-1">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div>
                        @if ($productCount)
                            <a href="{{ route('product#viewProduct') }}" class="mr-3 btn btn-outline-primary text-base">
                                All Products</a>
                        @endif
                    </div>
                    <div>
                        @if ($productCount)
                            <a href="{{ route('product#viewProduct', 'stock-less-than-5') }}"
                                class="mr-3 btn btn-outline-danger text-base">
                                stock less than 5</a>
                        @endif
                    </div>
                </div>
                <div class="btn btn-primary">
                    <span>Product Count - {{ $productCount }}</span>
                </div>
                <form style="width: 30%" action={{ route('product#viewProduct') }}>
                    <div class=" input-group">
                        <input name="searchKey" type="text" class="form-control" placeholder="Search..."
                            aria-label="Search..." aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div>
                <table class=" table mt-2 table-hover shadow-sm border">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($products) != 0)
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        @if (file_exists(public_path('admin/product/', $item->image)))
                                            <img style="width: 50px; height: 50px;" class="img-thumbnail"
                                                src="{{ asset('admin/product/' . $item->image) }}" alt={{ $item->name }}>
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td class="col-4">{{ Str::words($item->description, 10, '...') }}</td>
                                    <td class="text-center">{{ $item->category_name }}</td>
                                    <td class="col-2">

                                        <button type="button" class="btn btn-primary position-relative">
                                            {{ $item->stock }}
                                            @if ($item->stock <= 4)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    less than 5
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                    <td class="col-2">
                                        <a href="{{ route('product#detailPage', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('product#updatePage', $item->id) }}"
                                            class="btn btn-sm btn-outline-secondary"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{ route('product#delete', ['id' => $item->id, 'oldImage' => $item->image]) }}"
                                            class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (count($products) == 0)
                    <div class="text-center h4 mt-5">No Product Data!</div>
                @endif
            </div>
            <span class="mt-2 d-flex justify-content-end">
                {{ $products->links() }}
            </span>
        </div>
    </div>

@endsection
