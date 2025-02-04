@extends('user.layouts.master')

@section('title', 'Edit Profile')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection
@section('content')
    <div class="mt-5 py-5">
        <div class="card mt-5 py-3 container mx-auto">
            <div>
                <a href="{{ route('homePage') }}" class="mt-2 btn btn-primary"><i
                        class="fa-solid fa-arrow-left"></i><span class="ml-2">Back</span></a>
            </div>
            <form action="{{ route('profile#editProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-3 offset-1">
                        <div class="w-full">
                            <img id="image"
                                src="{{ asset($profileData->profile == null ? 'user/img/avatar.jpg' : 'profile/' . $profileData->profile) }}"
                                style="width: 350px; height:280px" class="img-thumbnail" alt="">
                            <input onchange="loadFile(event)" name="image" type="file"
                                class="form-control mt-2 @error('image')
                                 is-invalid
                            @enderror">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-7 offset-1 mt-2">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name', $profileData->name) }}"
                                    class="form-control @error('name')
                                        is-invalid
                                    @enderror">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="form-label">Nickname</label>
                                <input type="text" name="nickname" value="{{ old('nickname', $profileData->nickname) }}"
                                    class="form-control @error('nickname')
                                        is-invalid
                                    @enderror"
                                    placeholder="nickname...">
                                @error('nickname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $profileData->email) }}"
                                    class="form-control @error('email')
                                        is-invalid
                                    @enderror">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="form-label">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $profileData->phone) }}"
                                    class="form-control @error('phone')
                                        is-invalid
                                    @enderror">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="form-label">Address</label>
                            <textarea name="address"
                                class="form-control @error('address')
                                        is-invalid
                                    @enderror"
                                rows="3">{{ old('address', $profileData->address) }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <button type="submit" class="w-100 btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
