@extends('admin.layouts.master')
@section('title','payment update')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <a href="{{route('payment#paymentPage')}}" class="ml-3 btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <div class="row mt-5">
        <div class="col-4 offset-4 mr-2">
            <h3 class="text-primary fw-bold">Update Payment</h3>
            <form action="{{ route('payment#paymentUpdateProcess', $paymentData->id) }}" method="POST"
                class="p-4 mt-2 bg-gray-400 text-white rounded">
                @csrf
                <div class="form-floating mb-4">
                    <input type="text" name="accountNumber" value="{{ old('accountNumber', $paymentData->account_number) }}"
                        class="form-control @error('accountNumber')
                        is-invalid
                    @enderror"
                        id="floatingInput">
                    @error('accountNumber')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <input type="text" name="accountName" value="{{ old('accountName', $paymentData->account_name) }}"
                        class="form-control @error('accountName')
                        is-invalid
                    @enderror"
                        id="floatingInput">
                    @error('accountName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <input type="text" name="paymentType" value="{{ old('paymentType', $paymentData->type) }}"
                        class="form-control @error('paymentType')
                        is-invalid
                    @enderror"
                        id="floatingInput">
                    @error('paymentType')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">update payment</button>
            </form>
        </div>
    </div>
@endsection
