@extends('authentication.layouts.master')
@section('title', 'login')
@section('content')
    <div class="row">
        <div class="col-lg-8 offset-2">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <form action="{{ route('authLogin') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp"
                            placeholder="Enter Email Address...">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="Password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
                    <hr>
                    <a href="{{route('socialRedirect','google')}}" class="btn btn-google btn-user btn-block">
                        <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="{{route('socialRedirect','github')}}" class="btn  btn-dark btn-user btn-block">
                        <i class="fa-brands fa-github"></i> Login with Github
                    </a>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="{{ route('authRegister') }}">Create an Account!</a>
                </div>
            </div>
        </div>
    </div>
@endsection
