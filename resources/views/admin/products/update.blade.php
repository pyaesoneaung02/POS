@extends('admin.layouts.master')
@section('title', 'update product')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div><a href="{{ route('product#viewProduct') }}" class="ml-3 btn btn-primary text-base"><i
                class="fa-solid fa-arrow-left"></i>
            Back</a></div>
    <div class="text-center mb-3">
        <span class="text-lg font-weight-bold text-primary">Update Product</span>
    </div>
    <div class="row">
        <div style="margin-bottom: 30px" class="col-8 offset-2 shadow-sm p-4">
            <form action="{{ route('product#updateProcess') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name='oldImage' value="{{ $product->image }}">
                <input type="hidden" name='productId' value="{{ $product->id }}">
                <div class="mb-3 d-flex align-items-end row">
                    <div class="col-6">
                        <input type="file" name='image' onchange="loadFile(event)"
                            class="form-control @error('image')
                            is-invalid
                        @enderror">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <img style="width: 80% ; height: 250px;" class="img-thumbnail" id="imageSrc"
                            src="{{ asset('admin/product/' . $product->image) }}" alt="">
                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center row">
                    <div class="col-6">
                        <label style="font-weight: bold" class="form-label text-lg">Name</label>
                        <input type="text"
                            class="form-control @error('name')
                            is-invalid
                        @enderror"
                            name="name" value="{{ old('name', $product->name) }}" placeholder="Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label style="font-weight: bold" class="form-label text-lg">Category Name</label>
                        <select name="categoryId" @if (count($categories) <= 0) disabled @endif
                            class="form-control form-select form-select-lg  @error('categoryId')
                            is-invalid
                        @enderror">
                            <option value="">Choose category name</option>
                            @foreach ($categories as $item)
                                <option value={{ $item->id }} @if (old('categoryId', $product->category_id) == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('categoryId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 d-flex align-items-center row">
                    <div class="col-6">
                        <label style="font-weight: bold" class="form-label text-lg">Price</label>
                        <input type="number"
                            class="form-control  @error('price')
                            is-invalid
                        @enderror"
                            name='price' value="{{ old('price', $product->price) }}" placeholder="Price">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label style="font-weight: bold" class="form-label text-lg">Stock</label>
                        <input type="text"
                            class="form-control  @error('stock')
                            is-invalid
                        @enderror"
                            name='stock' value="{{ old('stock', $product->stock) }}" placeholder="Stock">
                        @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label style="font-weight: bold" class="form-label text-lg">Description</label>
                    <textarea
                        class="form-control  @error('description')
                            is-invalid
                        @enderror"
                        rows="3" name='description' placeholder="Description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 w-100">
                    <button type="submit" class="btn btn-primary w-100 py-2">Update</button>
                </div>

            </form>
        </div>
    </div>
@endsection
