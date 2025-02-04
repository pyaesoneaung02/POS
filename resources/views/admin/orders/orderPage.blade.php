@extends('admin.layouts.master')
@section('title', 'order page')
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
            <div class="row d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('adminDashboard') }}" class="btn btn-primary text-base"><i
                        class="fa-solid fa-arrow-left"></i>
                    Back</a>
                <h1 class="text-center font-weight-bold text-primary">User Orders</h1>
                <div></div>
            </div>


            <div class="row d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('orderPage') }}" class="btn btn-primary text-base">
                        All Orders</a>
                </div>
                <form style="width: 30%" action={{ route('orderPage') }}>
                    <div class=" input-group mb-3">
                        <input name="searchKey" type="text" class="form-control" placeholder="Search..."
                            aria-label="Search..." aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <div>
                <div class="row">
                    <table class="table mt-2 table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Order Code</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                                <tr>
                                    <input type="hidden" class="orderCode" value="{{ $item->order_code }}">
                                    <td>
                                        @if ($item->name)
                                            {{ $item->name }}
                                        @else
                                            {{ $item->nickname }}
                                        @endif
                                    </td>
                                    <td class="orderCode">
                                        <a href="{{ route('order#detail', $item->order_code) }}">
                                            {{ $item->order_code }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                        <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                    </td>
                                    <td>
                                        <select class="form-select statusChange" aria-label="Default select example">
                                            <option value="0" @if ($item->status == 0) selected @endif>
                                                pending</option>
                                            <option value="1" @if ($item->status == 1) selected @endif>
                                                success</option>
                                            <option value="2" @if ($item->status == 2) selected @endif>
                                                cancel</option>

                                        </select>
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <i class="fa-regular fa-clock text-warning"></i>
                                        @endif
                                        @if ($item->status == 1)
                                            <i class="fa-solid fa-check text-success"></i>
                                        @endif
                                        @if ($item->status == 2)
                                            <i class="fa-solid fa-xmark text-danger"></i>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                @if (count($orders) == 0)
                    <div class="text-center h4 mt-5">No Order Data!</div>
                @endif
                <span class="d-flex justify-content-end">
                    {{ $orders->links() }}
                </span>
            </div>
        </div>
    </div>
@endsection

@section('js-section')
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {
                $status = $(this).val();
                $orderCode = $(this).parents('tr').find('.orderCode').val();

                $data = {
                    'orderCode': $orderCode,
                    'status': $status
                }

                $.ajax({
                    type: 'get',
                    url: '/admin/order/statusChange',
                    data: $data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : ''
                    }
                })
            })

        })
    </script>
@endsection
