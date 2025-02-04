@extends('admin.layouts.master')

@section('title', 'updatePage')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <a href="{{route('category#list')}}" class="ml-3 btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <div class="row mt-5">
        <div class="col-4 offset-4 mr-2">
            <h3 class="text-primary fw-bold">Update Category Name</h3>
            <form action="{{ route('category#updateProcess', $category->id) }}" method="POST"
                class="p-4 mt-2 bg-gray-400 text-white rounded">
                <div class="form-floating mb-3">
                    @csrf
                    <input type="text" name="categoryName" value="{{ old('categoryName', $category->name) }}"
                        class="form-control @error('categoryName')
                        is-invalid
                    @enderror"
                        id="floatingInput" placeholder="category name">
                    @error('categoryName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">update category</button>
            </form>
        </div>
    </div>
@endsection
