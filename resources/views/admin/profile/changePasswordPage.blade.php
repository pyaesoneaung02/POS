@extends('admin.layouts.master')

@section('title', 'change password')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <a href="{{ url()->previous() }}" class="ml-3 btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <div class="row mt-5">
        <div class="col-4 offset-4 mr-2">
            <form action="{{ route('profile#changePasswordProcess') }}" method="POST"
                class="p-4 mt-2 bg-gray-400 text-white rounded">
                <div class="form-floating mb-3">
                    @csrf
                    <div>
                        <div style="position: relative;">
                            <span style="position: absolute;right: 30px; top:8px" class="old_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>
                            <input type="password" name="oldPassword"
                                class="input_type form-control mt-4 @error('oldPassword')
                                is-invalid
                            @enderror"
                                placeholder="old password">
                        </div>
                        @error('oldPassword')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div style="position: relative;">
                            <span style="position: absolute;right: 30px; top:8px" class="new_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>

                            <input type="password" name="newPassword"
                                class="input_type_n form-control mt-4 @error('newPassword')
                        is-invalid
                    @enderror"
                                placeholder="new password">
                            @error('newPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div>
                        <div style="position: relative;">
                            <span style="position: absolute;right: 30px; top:8px" class="confirm_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>
                            <input type="password" name="confirmPassword"
                                class="input_type_c form-control mt-4 @error('confirmPassword')
                            is-invalid
                            @enderror"
                                placeholder="confirm passwo">
                            @error('confirmPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">change password</button>
            </form>
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
                }else{
                    input.attr('type','password')
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
