@extends('admin.layouts.master')

@section('title', 'category')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div>
        <div class="row mx-5">
            <div class="col-4">
                <h3 class="text-primary fw-bold">Add Category Name</h3>
                <form action="{{ route('category#create') }}" method="POST" class="p-4 mt-5 bg-gray-400 text-white rounded">
                    <div class="form-floating mb-3">
                        @csrf
                        <input type="text" name="categoryName"
                            class="form-control @error('categoryName')
                            is-invalid
                        @enderror"
                            id="floatingInput" placeholder="category name">
                        @error('categoryName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">add category</button>
                </form>
            </div>
            <div class="col-8 position-relative">
                <h3>Category Lists</h3>
                <table class="table mt-5 table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Updated at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <div>{{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                    <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                </td>
                                <td>
                                    <div>{{ $item->updated_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                    <small>{{ $item->updated_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('category#updatePage', $item->id) }}"
                                        class="btn btn-sm btn-outline-secondary mr-2"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{ route('category#delete', $item->id) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @if (count($categories) == 0)
                    <div class="text-center h4 mt-5">No Category Data!</div>
                @endif
                <span class="mt-5 d-flex justify-content-end">
                    {{ $categories->links() }}
                </span>
            </div>
        </div>
    </div>
@endsection
