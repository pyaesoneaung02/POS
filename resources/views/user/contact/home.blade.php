@extends('user.layouts.master')
@section('title', 'contact page')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection
@section('content')
    <div class="mt-5 py-5">
        <div class="mt-5 py-5 row">
            <div class="card col-6 offset-3 py-3">
                <form action="{{ route('contactPage#contact') }}" method="post">
                    @csrf
                    <h4 class="text-center text-primary">Add User Content</h4>
                    <div class="mt-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" name="title"
                            class="form-control @error('title')
                        is-invalid
                    @enderror"
                            placeholder="title...">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Message</label>
                        <textarea name="message"
                            class="form-control @error('message')
                        is-invalid
                    @enderror"
                            placeholder="add message..."></textarea>
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
