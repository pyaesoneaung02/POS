@extends('admin.layouts.master')
@section('title', 'product detail')
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
    <div class="row">
        <div class="col-8 card mb-3 mx-auto" style="max-width: 100rem;">
            <div class="row g-0">
                <div class="col-4 px-0">
                    <img src="{{ asset('admin/product/' . $product->image) }}" class="img-fluid img-thumbnail rounded"
                        alt="{{ $product->name }}">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title mb-0 font-weight-bold text-primary">{{ $product->name }}</h5>
                        <p class="card-text mb-0"><small class="text-body-secondary"> <span
                                    class="font-weight-bold text-primary">Avaliable Product -</span>
                                {{ $product->stock }}</small></p>
                        <p class="card-text mb-0"><small class="text-body-secondary"><span
                                    class="font-weight-bold text-primary">Price -</span> {{ $product->price }} MMK</small>
                        </p>
                        <p class="card-text"><small class="text-body-secondary"><span
                                    class="font-weight-bold text-primary">Category -</span>
                                {{ $product->category_name }}</small>
                        </p>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text mb-0"><small class="text-body-secondary"><span class="font-weight-bold">Created at
                                    -</span>
                                {{ $product->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                        </p>
                        <p class="card-text"><small class="text-body-secondary"><span class="font-weight-bold">Last updated
                                    -</span>
                                {{ $product->updated_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
