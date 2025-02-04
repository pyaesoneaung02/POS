@extends('user.layouts.master')
@section('title', 'Change Password')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection

@section('content')

    <div class="mt-5 py-5">
        @session('currentPassword')
            <div>
                <span class="text-danger">
                    {{ session('currentPassword') }}
                </span>
            </div>
        @endsession
        <div class="row container mx-auto mt-5">
            <div>
                <a href="{{ route('homePage') }}" class="btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i>
                    Back</a>
            </div>
            <div class="row container mx-auto">
                <div class="card col-4 offset-4 py-4">
                    <div class="text-center">
                        <i class="fa-solid fa-key fs-5 text-primary"></i>
                        <span class="h4 text-primary">Change Password</span>
                    </div>
                    <form action="{{ route('changePassword#process') }}" method="POST">

                        @csrf
                        <div class="mt-4">
                            <label for="" class="form-label">Current Password</label>
                            <div style="position: relative;">
                                <span style="position: absolute;right: 30px; top:8px" class="old_password_eye"><i
                                        class="fa-solid fa-eye text-dark"></i></span>
                                <input type="password" name="currentPassword"
                                    class="input_type form-control @error('currentPassword')
                                is-invalid
                                @enderror"
                                    id="floatingInput">
                            </div>
                            @error('currentPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="mt-4">
                            <label for="" class="form-label">New Password</label>
                            <div style="position: relative;">
                                <span style="position: absolute;right: 30px; top:8px" class="new_password_eye"><i
                                        class="fa-solid fa-eye text-dark"></i></span>
                                <input type="password" name="newPassword"
                                    class="input_type_n form-control @error('newPassword')
                                is-invalid
                                @enderror"
                                    id="floatingInput">
                            </div>
                            @error('newPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="" class="form-label">Confirm Password</label>
                            <div style="position: relative;">
                                <span style="position: absolute;right: 30px; top:8px" class="confirm_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>
                                <input type="password" name="confirmPassword"
                                    class="input_type_c form-control @error('confirmPassword')
                             is-invalid
                             @enderror"
                                    id="floatingInput">
                            </div>
                            @error('confirmPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mt-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-section')
    <script>
        $(document).ready(function() {
            function changeText(input) {
                type = input.attr('type');
                if (type === 'password') {
                    input.attr('type', 'text')
                } else {
                    input.attr('type', 'password')
                }
            }
            $(".old_password_eye").click(function() {
                input = $(this).parents('div').find('.input_type')
                changeText(input)

            })
            $(".new_password_eye").click(function() {
                input = $(this).parents('div').find('.input_type_n')
                changeText(input)

            })
            $(".confirm_password_eye").click(function() {
                input = $(this).parents('div').find('.input_type_c')
                changeText(input)

            })
        })
    </script>
@endsection
