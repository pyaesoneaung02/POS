@extends('user.layouts.master')
@section('title', 'cart page')

@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <div class="mb-3 mt-3">
                    <a href="{{ route('homePage') }}" class="btn btn-primary w-fit">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>
                <table class="table" id="productCartTable">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" class="userId" value="{{ Auth::user()->id }}">
                        @foreach ($carts as $item)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('admin/product/' . $item->image) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                            alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->name }}</p>
                                </td>
                                <td>
                                    <p class="price mb-0 mt-4">{{ $item->price }} mmk</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="qty form-control form-control-sm text-center border-0"
                                            value="{{ $item->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total">{{ $item->price * $item->qty }} mmk</p>
                                </td>
                                <td>
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="cartId" value='{{ $item->cart_id }}'>
                                    <button class="btn-delete btn btn-md rounded-circle bg-light border mt-4">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0" id="subtotal">{{ $total }} mmk</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Delivery</h5>
                                <div class="">
                                    <p class="mb-0">Flat rate: 500 mmk</p>
                                </div>
                            </div>
                            {{-- <p class="mb-0 text-end">Shipping to Ukraine.</p> --}}
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4" id="finalTotal">{{ $total + 500 }} mmk</p>
                        </div>
                        <button id="checkout_btn"
                            class="@if (count($carts) <= 0) disabled @endif btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                            type="button">Proceed Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@section('js-section')
    <script>
        $(document).ready(function() {
            //minus btn click
            $('.btn-minus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = $parentNode.find('.price').text().replace('mmk', '')
                $qty = $parentNode.find('.qty').val();
                $totalAtm = $price * $qty;
                $parentNode.find(".total").text($totalAtm + "mmk")
                finalCalculation();
            })
            //plus btn click
            $('.btn-plus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = $parentNode.find('.price').text().replace('mmk', '')
                $qty = $parentNode.find('.qty').val();
                $totalAtm = $price * $qty;
                $parentNode.find(".total").text($totalAtm + "mmk")
                finalCalculation();
            })

            //delete btn click
            $('.btn-delete').click(function() {
                $parentNode = $(this).parents("tr");
                $cartId = $parentNode.find('.cartId').val();

                $data = {
                    "cartId": $cartId
                }

                $.ajax({
                    method: "get",
                    url: '/user/product/cart/delete',
                    data: $data,
                    dataType: 'json',
                    success: function(response) {
                        response.status == 'success' ? location.reload() : ""

                    }
                })

            })

            //checkout btn click
            $('#checkout_btn').click(function() {
                $orderList = [];
                $userId = $('.userId').val();
                $orderCode = "POS_OC- " + Math.floor(Math.random() * 100000000)
                $totalAtm = $('#finalTotal').text().replace('mmk', '')

                $('#productCartTable tbody tr').each(function(index, row) {
                    $productId = $(row).find('.productId').val()
                    $count = $(row).find('.qty').val()
                    $orderList.push({
                        'productId': $productId,
                        'userId': $userId,
                        'count': $count,
                        'orderCode': $orderCode,
                        'totalAtm': $totalAtm,
                    })
                })
                $.ajax({
                    type: 'get',
                    url: '/user/cart/temp',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 'success') {
                            location.href = '/user/payment'
                        }
                    }
                })
            })
        })

        function finalCalculation() {
            $total = 0;
            $('#productCartTable tbody tr').each(function(index, item) {
                $total += Number($(item).find('.total').text().replace('mmk', ''))
            })

            $('#subtotal').html(`${$total} mmk`);
            $('#finalTotal').html(`${$total + 500} mmk`);
        }
    </script>
@endsection
