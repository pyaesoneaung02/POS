@extends('user.layouts.master')
@section('title', 'order page')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection
@section('content')
    <div class="mt-5 py-5">
        <div class="row container mx-auto">
            <div>
                <a href="{{ route('homePage') }}" class=" mt-5 btn btn-primary text-base"><i
                        class="fa-solid fa-arrow-left"></i>
                    Back</a>
            </div>
        </div>
        <div class="row container mx-auto">
            <div class="col-12">
                <table class=" table mt-2 table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Order Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderData as $item)
                            <tr>
                                <th>{{ $item->order_code }}</th>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="btn btn-warning btn-sm rounded shadow-sm">pending</span>
                                    @elseif ($item->status == 1)
                                        <span class="btn btn-success btn-sm rounded shadow-sm">accept</span>
                                        <span>
                                            <i class="fa-regular fa-clock text-warning"></i>
                                            <span class="text-warning">please wait 3 days</span>
                                        </span>
                                    @else
                                        <span class="btn btn-danger btn-sm rounded shadow-sm">reject</span>
                                        <span class="text-warning">Thank you for your order!</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                    <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
