@extends('admin.layouts.master')
@section('title', 'create admin')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div class="mx-3 d-flex justify-content-between">
        <a href="{{ route('adminDashboard') }}" class="btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i>
            Back</a>
        <a href="{{ route('profile#adminAccounts') }}" class="btn btn-secondary text-base"><i
                class="fa-solid fa-users mr-1"></i>
            See Accounts</a>
    </div>
    <div class="row">
        <div class="col-6 offset-3">
            <div class="text-center">
                <h3 class="text-primary font-weight-bold">Create Admin Account</h3>
            </div>
            <form action="{{ route('profile#createAdminProcess') }}" method="POST"
                class="px-5 pt-2 pb-4 bg-gray-400 text-white shadow rounded">
                <div class="form-floating mb-3">
                    @csrf
                    <div class="mt-3">
                        <label for="" class="text-dark font-weight-bold text-lg">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name')
                                is-invalid
                            @enderror"
                            id="floatingInput" placeholder="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="" class="text-dark font-weight-bold text-lg">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}"
                            class="form-control @error('email')
                                is-invalid
                            @enderror"
                            id="floatingInput" placeholder="example@gmail.com">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="" class="text-dark font-weight-bold text-lg">Password</label>
                        <div style="position: relative;">
                            <span style="position: absolute;right: 30px; top:8px" class="new_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>
                            <input type="password" name="password"
                                class="input_type_n form-control @error('password')
                                    is-invalid
                                @enderror"
                                id="" placeholder="password">
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="" class="text-dark font-weight-bold text-lg">Confirm Password</label>
                        <div style="position: relative;">
                            <span style="position: absolute;right: 30px; top:8px" class="confirm_password_eye"><i
                                    class="fa-solid fa-eye text-dark"></i></span>
                            <input type="password" name="confirm_password"
                                class="input_type_c form-control @error('confirm_password')
                                is-invalid
                            @enderror"
                                id="floatingInput" placeholder="confirm password">
                        </div>
                        @error('confirm_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 shadow">Create Admin Account</button>
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
                } else {
                    input.attr('type', 'password')
                }
            }
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
