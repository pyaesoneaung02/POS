@extends('authentication.layouts.master')
@section('title', 'register')
@section('content')
    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                </div>
                <form action="{{ route('authRegister') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="number" name='phone' value="{{ old('phone') }}"
                                class="form-control form-control-user" id="exampleLastName" placeholder="Phone">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" name="password" class="form-control form-control-user"
                                id="exampleInputPassword" placeholder="Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="password_confirmation" class="form-control form-control-user"
                                id="exampleRepeatPassword" placeholder="Repeat Password">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Register Account
                    </button>
                    {{-- <hr>
                    <a href="index.html" class="btn btn-google btn-user btn-block">
                        <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-user btn-block">
                        <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a> --}}
                </form>
                <hr>
                {{-- <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div> --}}
                <div class="text-center">
                    <a class="small" href="{{ route('authLogin') }}">Already have an account? Login!</a>
                </div>
            </div>
        </div>
    </div>
@endsection
