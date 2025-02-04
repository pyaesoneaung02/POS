@extends('admin.layouts.master')
@section('title', 'payment page')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div class="row mx-5">
        <div class="col-4">
            <h3 class="text-primary fw-bold">Add Category Name</h3>
            <form action="{{ route('payment#paymentCreate') }}" method="POST" class="p-4 mt-5 bg-gray-400 text-white rounded">
                @csrf
                <div class="form-floating mb-4">
                    <label class="form-label font-weight-bold text-dark">Account Number</label>
                    <input type="text" name="accountNumber" value="{{ old('accountNumber') }}"
                        class="form-control @error('accountNumber')
                            is-invalid
                        @enderror"
                        id="floatingInput" placeholder="add account number">
                    @error('accountNumber')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <label class="form-label font-weight-bold text-dark">Account Name</label>
                    <input type="text" name="accountName" value="{{ old('accountName') }}"
                        class="form-control @error('accountName')
                            is-invalid
                        @enderror"
                        id="floatingInput" placeholder="add account name">
                    @error('accountName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <label class="form-label font-weight-bold text-dark">Payment Type</label>
                    <input type="text" name="paymentType" value="{{ old('paymentType') }}"
                        class="form-control @error('paymentType')
                            is-invalid
                        @enderror"
                        id="floatingInput" placeholder="add payment type">
                    @error('paymentType')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Payment</button>
            </form>
        </div>
        <div class="col-8 position-relative">
            <h3>Category Lists</h3>
            <table class="table mt-5 table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Account Name</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentData as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->account_number }}</td>
                            <td>{{ $item->account_name }}</td>
                            <td>{{ $item->type }}</td>

                            <td class="d-flex gap-2">
                                <a href="{{ route('payment#paymentUpdatePage', $item->id) }}"
                                    class="btn btn-sm btn-outline-secondary mr-2"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href="{{ route('payment#paymentDelete', $item->id) }}"
                                    class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            @if (count($paymentData) == 0)
                <div class="text-center h4 mt-2">No PaymentData!</div>
            @endif
            <span class="mt-5 d-flex justify-content-end">
                {{ $paymentData->links() }}
            </span>
        </div>
    </div>

@endsection
