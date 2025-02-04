@extends('admin.layouts.master')
@section('title', 'Sale Info')
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
            <div class="row">
                <div class="col-7 px-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('adminDashboard') }}" class="btn btn-primary text-base"><i
                            class="fa-solid fa-arrow-left"></i>
                        Back</a>
                    <h2 class="text-center font-weight-bold text-primary">Sale Information</h2>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="w-100 fw-bold d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('salePage') }}" class="mr-3 btn btn-primary text-base">
                                All Sale Info</a>
                            <h5>Total Price - <span class="border-2 border-primary">{{ $totalPrice }} mmk</span></h5>
                        </div>

                        <form style="width: 30%" action={{ route('salePage') }}>
                            <div class=" input-group mb-3">
                                <input name="searchKey" type="text" class="form-control" placeholder="Search..."
                                    aria-label="Search..." aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Order Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Count</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saleInfo as $item)
                                <tr>
                                    <td>
                                        {{ $item->order_code }}
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->count }}
                                    </td>
                                    <td>
                                        {{ $item->phone }}
                                    </td>
                                    <td>
                                        {{ $item->address }}
                                    </td>
                                    <td>
                                        {{ $item->total_price }} mmk
                                    </td>
                                    <td>
                                        <div>{{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                        <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @if (count($saleInfo) == 0)
                        <div class="text-center h4 mt-5">No Sale Data!</div>
                    @endif
                </div>
            </div>
            <span class="w-100 d-flex justify-content-end">
                {{ $saleInfo->links() }}
            </span>
        </div>
    </div>
@endsection
