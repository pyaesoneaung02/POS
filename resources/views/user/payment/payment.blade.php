@extends('user.layouts.master')
@section('title', 'payment')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection
@section('content')
    <div class="container-fluid py-5 mt-5 mb-5">
        <div class="mt-5 row container mx-auto px-0">
            <div style="max-height: 500px; overflow: auto" class="col-5">
                @foreach ($payment as $item)
                    <div>
                        <h6>
                            <span style="font-size: 18px">Name -</span> {{ $item->account_name }}
                        </h6>
                        <h6><span style="font-size: 18px">Payment Type -</span> {{ $item->type }}</h6>
                        <h6><span style="font-size: 18px">Payment Number - </span>{{ $item->account_number }}</h6>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product#orderProcess') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" name="name"
                                        value="{{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}"
                                        readonly
                                        class="form-control  @error('name')
                                        is-invalid
                                    @enderror">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Phone</label>
                                    <input type="number" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                        placeholder="09xxxxxxxxx"
                                        class="form-control @error('phone')
                                        is-invalid
                                    @enderror">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label">Address</label>
                                    <textarea type="text" name="address" rows="1"
                                        class="form-control @error('address')
                                        is-invalid
                                    @enderror"
                                        placeholder="address...">{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <label for="" class="form-label">Select Payment type</label>
                                    <select name="paymentType"
                                        class="form-select  @error('paymentType')
                                        is-invalid
                                    @enderror">
                                        <option value="">Select payment type</option>
                                        @foreach ($payment as $item)
                                            <option value="{{ $item->type }}"
                                                @if (old('paymentType') == $item->type) selected @endif>
                                                {{ $item->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('paymentType')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">Add invoice image</label>
                                    <input name="payslipImage"
                                        class="form-control form-control  @error('payslipImage')
                                        is-invalid
                                    @enderror"
                                        type="file">
                                    @error('payslipImage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <input type="hidden" name="orderCode" value="{{ $orderProduct[0]['order_code'] }}">
                                    <span>OrderCode -</span><span
                                        class="text-primary fw-bold">{{ $orderProduct[0]['order_code'] }}</span>
                                </div>
                                <div class="col-6">
                                    <input type="hidden" name="totalAtm" value="{{ $orderProduct[0]['total_atm'] }}">
                                    <span>Total Amount -</span><span
                                        class="text-primary fw-bold">{{ $orderProduct[0]['total_atm'] }} mmk</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-3">Order Now</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
