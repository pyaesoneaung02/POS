@extends('admin.layouts.master')
@section('title', 'content page')
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
            <div>
                <a href="{{ route('adminDashboard') }}" class="btn btn-primary text-base"><i
                        class="fa-solid fa-arrow-left"></i>
                    Back</a>
            </div>
            <div>
                <h1 class="text-center font-weight-bold text-primary mb-5">User Contacts</h1>
            </div>
            <div>
                <table class="table mt-2 table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Title</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $item)
                            <tr>
                                <td>
                                    @if ($item->name)
                                        {{ $item->name }}
                                    @else
                                        {{ $item->nickname }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td>
                                    {{ $item->message }}
                                </td>
                                <td>
                                    <div>{{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}</div>
                                    <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @if (count($contacts) == 0)
                    <div class="text-center h4 mt-5">No Contact Data!</div>
                @endif
                <span class="d-flex justify-content-end">
                    {{ $contacts->links() }}
                </span>
            </div>
        </div>
    </div>
@endsection
