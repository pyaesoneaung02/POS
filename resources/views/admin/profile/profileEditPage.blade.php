@extends('admin.layouts.master')

@section('title', 'edit page')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <a href="{{ route('profile#profilePage') }}" class="ml-3 btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i>
        Back</a>

    <div class="card shadow container bg-light py-3 mt-3">
        <div class="bg-muted border-bottom opacity-40">
            <h5 class="font-weight-bold">Admin Profile(<span class="text-primary">{{ Auth::user()->role }} role</span>)</h5>
        </div>
        <form action="{{ route('profile#profileEditPageProcess') }}" method="POST" enctype="multipart/form-data">
            <div class="row py-3">
                @csrf
                <div class="col-3">
                    <div style="width: 250px" class="">
                        <img style="width: 250px; height:250px" class="img-thumbnail"
                            src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('admin/img/undraw_profile.svg') }}"
                            id="imageSrc" alt="">
                        <div style="width: 100%" class="input-group mb-3">
                            <input type="file" name='image' class="form-control"
                                onchange="loadFile(event)">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="" class="form-label font-weight-bold">Name</label>
                            <input type="text" name="name"
                                value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}"
                                class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                id="" placeholder="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-5 mb-3">
                            <label for="" class="form-label font-weight-bold">Email</label>
                            <input type="email" name='email' value="{{ old('email', Auth::user()->email) }}"
                                class="form-control @error('email')
                                is-invalid
                            @enderror"
                                id="" placeholder="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="" class="form-label font-weight-bold">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                class="form-control @error('phone')
                                is-invalid
                            @enderror"
                                id="" placeholder="phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-5 mb-3">
                            <label for="" class="form-label font-weight-bold">Address</label>
                            <textarea name="address"
                                class="form-control @error('address')
                                is-invalid
                            @enderror"
                                id="" placeholder="address...">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="sumbit" class="btn btn-primary">upload</button>
                </div>
            </div>
        </form>
    </div>
@endsection
