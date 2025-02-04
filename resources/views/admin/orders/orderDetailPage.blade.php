@extends('admin.layouts.master')

@section('title', 'order detail page')
@section('orderCount')
    @if ($pending_order > 0)
        <span
            class="position-absolute bg-danger rounded-circle d-flex align-items-center justify-content-center text-white px-1"
            style="top: -8px; left: 25px; height: 20px; min-width: 20px;">{{ $pending_order }}</span>
    @endif
@endsection
@section('content')
    <div class="container-fluid mx-auto">
        <div class="mx-5">
            <div class="mb-3">
                <a href="{{ route('orderPage') }}" class="btn btn-primary text-base"><i class="fa-solid fa-arrow-left"></i>
                    Back</a>
            </div>
            <div class="row">
                <div class="col-5 offset-1 card">
                    <div class="card-body">
                        <h5 class="card-title text-primary font-weight-bold text-center">User Account Info</h5>
                        <div class="row mt-4">
                            <div class="col-3">
                                Username
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $order[0]['name'] }}
                            </div>
                        </div>
                        @if ($order[0]['phone'])
                            <div class="row mt-2">
                                <div class="col-3">
                                    Phone
                                </div>
                                <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                                <div class="col-6">
                                    {{ $order[0]['phone'] }}
                                </div>
                            </div>
                        @endif
                        @if ($order[0]['address'])
                            <div class="row mt-2">
                                <div class="col-3">
                                    Address
                                </div>
                                <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                                <div class="col-6">
                                    {{ $order[0]['address'] }}
                                </div>
                            </div>
                        @endif
                        <hr>
                        <h5 class="card-title text-primary font-weight-bold text-center">User Order Info</h5>
                        <div class="row mt-4">
                            <div class="col-3">
                                Username
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $paymentHistory->user_name }}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-3">
                                Phone
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $paymentHistory->phone }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                Address
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $paymentHistory->address }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                PaymentType
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $paymentHistory->payment_type }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                Order Code
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div id="orderCode" class="col-6">
                                {{ $paymentHistory->order_code }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                Order Date
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                {{ $paymentHistory->created_at->format('j-M-Y', 'h\h : i\m\i\n : s\s a') }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                Total Price
                            </div>
                            <div class="col-1"><i class="fa-solid fa-minus"></i></div>
                            <div class="col-6">
                                <div>{{ $paymentHistory->total_atm }} mmk</div>
                                <span class="text-danger">( Contain Delivery Charges)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 card h-fit">
                    <div class="card-body h-fit">
                        <h5 class="card-title text-primary font-weight-bold text-center">User Order Invoice</h5>
                        <div class="mt-4 text-center">
                            <img src="{{ asset('payslip/' . $paymentHistory->payslip_image) }}"
                                class="w-50 h-50 img-thumbnail" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h1 class="font-weight-bold text-primary mb-2">Order Products</h1>
                    <table id="orderTable" class=" table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Count</th>
                                <th scope="col">Available</th>
                                <th scope="col">Price (each)</th>
                                <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $item)
                                <tr>
                                    <input type="hidden" class="product_id" value="{{ $item->product_id }}">
                                    <input type="hidden" class="product_count" value="{{ $item->count }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('admin/product/' . $item->image) }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="">
                                        </div>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>

                                        <button type="button" class="btn btn-primary position-relative">
                                            {{ $item->count }}
                                            @if ($item->count > $item->stock)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <span class="visually-hidden">Available {{ $item->stock }}
                                                        Stock</span>
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->price * $item->count }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mb-5">
                        <div>
                            <button id="cancel_btn" @if ($order[0]['status'] == 2) disabled @endif
                                class="btn btn-danger">Cancel</button>
                            <button id="confirm_btn" @if (!$status || $order[0]['status'] == 1 || $order[0]['status'] == 2) disabled @endif
                                class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                    {{-- <span class="mt-5 d-flex justify-content-end">
                        {{ $accounts->links() }}
                    </span> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-section')
    <script>
        $(document).ready(function() {
            $('#confirm_btn').click(function() {
                $orderList = [];
                $orderCode = $('#orderCode').text().trim()
                $('#orderTable tbody tr').each(function(index, row) {
                    $productId = $(row).find('.product_id').val()
                    $order_count = $(row).find('.product_count').val()
                    $orderList.push({
                        'order_code': $orderCode,
                        'product_id': $productId,
                        'order_count': $order_count
                    })
                })
                $.ajax({
                    type: 'get',
                    url: '/admin/order/confirm',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 'success') {
                            location.href = '/admin/order/order'
                        }
                    }
                })

            })
            $('#cancel_btn').click(function() {
                $orderCode = $('#orderCode').text().trim()
                $data = {
                    "order_code": $orderCode,
                }
                $.ajax({
                    type: 'get',
                    url: '/admin/order/cancel',
                    data: $data,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 'success') {
                            location.href = '/admin/order/order'
                        }
                    }
                })

            })
        })
    </script>
@endsection
