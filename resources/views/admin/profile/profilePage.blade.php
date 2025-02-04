@extends('admin.layouts.master')
@section('title', 'profile')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div class="row container">
        <div class="col-4 offset-1">
            <img style="width: 200px; height: 200px;" class="w-[100px] h-[100px]"
                src="{{ Auth::user()->profile != null ? asset('profile/' . Auth::user()->profile) : asset('admin/img/undraw_profile.svg') }}"
                alt="">
            <div class="mt-4">
                <span class="font-weight-bold ">Role -</span> <span class="text-primary">{{ Auth::user()->role }}</span>
            </div>
        </div>
        <div class="col-6 d-flex flex-column gap-5">
            <div class="mt-4 d-flex">
                <h5 class="fw-bold text-secondary-emphasis mr-4">Name -</h5>
                <div>{{ Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name }}</div>
            </div>
            <div class="mt-4 d-flex">
                <h5 class="fw-bold text-secondary-emphasis mr-4">Email -</h5>
                <div>{{ Auth::user()->email }}</div>
            </div>
            @if (Auth::user()->phone != null && Auth::user()->address != null)
                <div class="mt-4 d-flex">
                    <h5 class="fw-bold text-secondary-emphasis mr-4">Phone -</h5>
                    <div>{{ Auth::user()->phone }}</div>
                </div>
                <div class="mt-4 d-flex">
                    <h5 class="fw-bold text-secondary-emphasis mr-4">Address -</h5>
                    <div>{{ Auth::user()->address }}</div>
                </div>
            @endif
            <div class="mt-5 d-flex justify-content-between">
                <div class="d-flex align-items-baseline">
                    <a href="{{ route('profile#profileEditPage') }}" class="btn btn-primary mr-2"><i
                            class="fa-solid fa-pen-to-square mr-2"></i><span>Edit</span></a>
                    <a href="{{ route('profile#changePasswordProcess') }}" class="btn btn-primary"><i
                            class="fa-solid fa-key mr-2"></i><span>Change Password</span></a>
                </div>
                <div class="d-flex flex-column">
                    <span><small class="font-weight-bold">Create at -
                        </small>{{ Auth::user()->created_at->timezone('Asia/Yangon')->format('j/M/Y') }}</span>
                    <spna><small class="font-weight-bold">Update at -
                        </small>{{ Auth::user()->updated_at->timezone('Asia/Yangon')->format('j/M/Y') }}</spna>
                </div>
            </div>
        </div>
    </div>
@endsection
