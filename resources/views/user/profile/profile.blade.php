@extends('user.layouts.master')
@section('title', 'profile')
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
                <a href="{{ route('homePage') }}" class="mt-2 btn btn-primary"><i class="fa-solid fa-arrow-left"></i><span
                        class="ml-2">Back</span></a>
            </div>
            <div class="row">
                <div class="col-3 offset-1">
                    <div class="w-full">
                        <img src="{{ asset($profileData->profile == null ? 'user/img/avatar.jpg' : 'profile/' . $profileData->profile) }}"
                            class="w-100 h-50 img-thumbnail" alt="">
                    </div>
                </div>
                <div class="col-7 offset-1 mt-2">
                    @if ($profileData->name)
                        <div class="row mb-3">
                            <h5 class="col-2">Name</h5>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <h6 class="col-7">{{ $profileData->name }}</h6>
                        </div>
                    @endif
                    @if ($profileData->nickname)
                        <div class="row mb-3">
                            <h5 class="col-2">Nickname</h5>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <h6 class="col-7">{{ $profileData->nickname }}</h6>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <h5 class="col-2">Email</h5>
                        <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                        <h6 class="col-7">{{ $profileData->email }}</h6>
                    </div>
                    @if ($profileData->phone)
                        <div class="row mb-3">
                            <h5 class="col-2">Phone</h5>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <h6 class="col-7">{{ $profileData->phone }}</h6>
                        </div>
                    @endif
                    @if ($profileData->address)
                        <div class="row mb-3">
                            <h5 class="col-2">Address</h5>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <h6 class="col-7">{{ $profileData->address }}</h6>
                        </div>
                    @endif

                    <div>
                        <a href="{{ route('profile#edit') }}" class="btn btn-primary ">
                            <span><i class="fa-solid fa-user-pen"></i></span>
                            <span>Edit</span>
                        </a>
                        <a href="{{route('changePassword')}}" class="btn btn-primary ">
                            <span><i class="fa-solid fa-key"></i></span>
                            <span>Change Password</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
