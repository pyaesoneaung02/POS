@extends('user.layouts.master')
@section('title', 'detail Page')
@section('cartNumber')
    @if ($cartNumber > 0)
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $cartNumber }}</span>
    @endif
@endsection
@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="mb-3">
                <a href="{{ route('homePage') }}" class="btn btn-primary w-fit">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>

            <!---- Product Detail Section ----Start---->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="row g-4">
                        <!---- Product Detail Image Section ----Start---->
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <img src="{{ asset('admin/product/' . $products->image) }}" style="width: 100%; max-height: 400px"
                                    class="img-fluid rounded"  alt="Image">
                            </div>
                        </div>
                        <!---- Product Detail Image Section ----End---->

                        <!---- Product Detail Description Section ----Start---->
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $products->name }} <span
                                    class="text-warning h6">({{ $products->stock }} items left!)</span></h4>
                            <p class="mb-3">Category : <span class="h5">{{ $products->category_name }}</span></p>
                            <h5 class="fw-bold mb-3">{{ $products->price }} MMK</h5>
                            <div class="d-flex gap-4 align-items-center mb-4">
                                @if ($viewTime > 0)
                                    <div class="bg-primary px-2 py-1 rounded">
                                        <span class="text-white">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                        <span class="font-weight-bold text-white">{{ $viewTime }}</span>
                                    </div>
                                @endif
                                <div>
                                    @php
                                        $ratingAvg = number_format($ratingAvg);
                                    @endphp
                                    @for ($i = 1; $i <= $ratingAvg; $i++)
                                        <i class="fa fa-star text-secondary"></i>
                                    @endfor
                                    @for ($j = $ratingAvg + 1; $j <= 5; $j++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>

                            </div>
                            <p class="mb-4">{{ $products->description }}</p>
                            <div class="d-flex align-items-end gap-4">
                                <form action="{{ route('product#cart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{ $products->id }}">
                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                    <div class="input-group quantity mb-5" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button type="button"
                                                class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="qty"
                                            class="form-control form-control-sm text-center border-0" value="1">
                                        <div class="input-group-btn">
                                            <button type="button"
                                                class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                </form>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"
                                    data-bs-toggle="modal" data-bs-target="#ratingModal"><i
                                        class="fa-solid fa-star me-2 text-primary"></i> Rating</button>

                                <form action="{{ route('ratingProcess') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{ $products->id }}">
                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                    <!-- Modal -->
                                    <div class="modal fade" id="ratingModal" tabindex="-1"
                                        aria-labelledby="ratingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Product Rating</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="rating-css">
                                                        <div class="star-icon">
                                                            @if ($ratingCount == 0)
                                                                <input type="radio" value="1" name="productRating"
                                                                    checked id='rating1'>
                                                                <label for="rating1" class="fa fa-star"></label>
                                                                <input type="radio" value="2" name="productRating"
                                                                    id='rating2'>
                                                                <label for="rating2" class="fa fa-star"></label>
                                                                <input type="radio" value="3" name="productRating"
                                                                    id='rating3'>
                                                                <label for="rating3" class="fa fa-star"></label>
                                                                <input type="radio" value="4" name="productRating"
                                                                    id='rating4'>
                                                                <label for="rating4" class="fa fa-star"></label>
                                                                <input type="radio" value="5" name="productRating"
                                                                    id='rating5'>
                                                                <label for="rating5" class="fa fa-star"></label>
                                                            @else
                                                                @for ($i = 1; $i <= $ratingCount; $i++)
                                                                    <input type="radio" value="{{ $i }}"
                                                                        name="productRating" checked
                                                                        id='rating{{ $i }}'>
                                                                    <label for="rating{{ $i }}"
                                                                        class="fa fa-star"></label>
                                                                @endfor
                                                                @for ($j = $ratingCount + 1; $j <= 5; $j++)
                                                                    <input type="radio" value="{{ $j }}"
                                                                        name="productRating"
                                                                        id='rating{{ $j }}'>
                                                                    <label for="rating{{ $j }}"
                                                                        class="fa fa-star"></label>
                                                                @endfor
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Rating</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!---- Product Detail Description Section ----End---->

                        <!---- Product Detail Comment Section ----Start---->
                        <div class="row gap-4 mt-5">
                            <!----Add Comment Section ----Start---->
                            <form class="col-4" action="{{ route('comment') }}" method="post">
                                @csrf
                                <input type="hidden" name="productId" value="{{ $products->id }}">
                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                <h4 class="mb-4 fw-bold">Add Comments</h4>
                                <div class="row g-1">
                                    <div class="col-lg-12">
                                        <div class="border-bottom rounded">
                                            <textarea name="comment" id="" class="form-control" cols="30" rows="3"
                                                placeholder="Add comment" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between py-3 mb-5">
                                            <button type="submit"
                                                class="btn border border-secondary text-primary rounded-md px-4 py-2">
                                                Add
                                                Comment</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!----Add Comment Section ----End---->

                            <!----View Comment Section ----Start---->
                            <div class="col-7">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link border-white border-bottom-0" type="button"
                                            role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-mission" aria-controls="nav-about" aria-selected="true">
                                            <span>
                                                Comments
                                            </span>
                                            <span class="badge rounded bg-primary">
                                                {{ count($comments) }}
                                            </span>
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    @if (count($comments) > 0)
                                        <div style="height: 500px; overflow: auto" class="tab-pane active" id="nav-about"
                                            role="tabpanel" aria-labelledby="nav-about-tab">
                                            @foreach ($comments as $item)
                                                <div class="d-flex justify-content-between">
                                                    <div class="w-75 d-flex justify-content-start align-items-start gap-4">
                                                        <div>
                                                            <img src="{{ asset($item->profile == null ? 'user/img/avatar.jpg' : 'profile/' . $item->profile) }}"
                                                                class="img-fluid rounded-circle p-1"
                                                                style="width: 60px; height: 60px;" alt="">
                                                            <div
                                                                class="d-flex flex-column text-center justify-content-center">
                                                                <h5>{{ $item->name != null ? $item->name : $item->nickname }}
                                                                </h5>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <div class="d-flex">
                                                                @foreach ($allRating as $rating)
                                                                    @if ($rating->user_id == $item->user_id && $rating->product_id == $item->product_id)
                                                                        @php
                                                                            $ratingAvg = number_format($rating->count);
                                                                        @endphp
                                                                        @for ($i = 1; $i <= $ratingAvg; $i++)
                                                                            <i class="fa fa-star text-secondary"></i>
                                                                        @endfor
                                                                        @for ($j = $ratingAvg + 1; $j <= 5; $j++)
                                                                            <i class="fa fa-star"></i>
                                                                        @endfor
                                                                    @endif
                                                                @endforeach

                                                            </div>
                                                            <p class="mb-2" style="font-size: 14px;">
                                                            <div class="text-primary">
                                                                {{ $item->created_at->timezone('Asia/Yangon')->format('j-M-Y') }}
                                                            </div>
                                                            <small>{{ $item->created_at->timezone('Asia/Yangon')->format('h\h : i\m\i\n : s\s a') }}</small>
                                                            </p>
                                                            <p>{{ $item->message }}</p>
                                                        </div>
                                                    </div>

                                                    @if ($item->user_id == Auth::user()->id)
                                                        <div
                                                            class="w-50 px-3 d-flex gap-2 justify-content-end align-items-end">
                                                            <div class="comment_delete_btn">
                                                                <input type="hidden" class="deleteCommentId"
                                                                    name="commentId" value="{{ $item->id }}">
                                                                <button class="border-0 px-2 py-1"><i
                                                                        class="fa-solid fa-trash text-danger"></i><span
                                                                        class="text-danger">delete</span></button>

                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <!----View Comment Section ----End---->
                        </div>
                        <!---- Product Detail Comment Section ----End---->
                    </div>
                </div>
            </div>
            <!---- Product Detail Section ----End---->

            <!---- Related Product Section ----Start---->
            @if (count($relateProducts) > 0)
                <h1 class="fw-bold mb-4">Related products</h1>
                <div class="vesitable">
                    <div
                        class="@if (count($relateProducts) > 4) owl-carousel vegetable-carousel justify-content-center @else d-flex justify-content-start gap-3 @endif">
                        @foreach ($relateProducts as $item)
                            <div style="height: 470px"
                                class="@if (count($relateProducts) <= 4) col-3 @endif border border-primary rounded position-relative vesitable-item">
                                <div class="vesitable-img border border-primary">
                                    <img src="{{ asset('admin/product/' . $item->image) }}" style="height: 250px"
                                        class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; right: 10px;">{{ $item->category_name }}</div>
                                <div style="height: 200px"
                                    class="p-4 pb-0 rounded-bottom d-flex flex-column justify-content-between">
                                    <h4>{{ $item->name }}</h4>
                                    <p>{{ Str::words($item->description, 10, '...') }}</p>
                                    <div class="w-100 d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="text-dark fs-5 fw-bold mb-0">{{ $item->price }}mmk
                                            </p>
                                            <a href="#" style="font-size: 12px"
                                                class="text-start btn border border-secondary rounded-pill px-2 text-primary"><i
                                                    class="fa fa-shopping-bag me-1 text-primary"></i> Add to
                                                cart</a>
                                        </div>
                                        <div>
                                            <a href="{{ route('product#detail', $item->id) }}" style="font-size: 12px"
                                                class="btn border border-secondary rounded-md px-2 text-primary">
                                                Read more...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
            <!---- Related Product Section ----End---->
        </div>
    </div>
    <!-- Single Product End -->
@endsection

@section('js-section')
    <script>
        $(document).ready(function() {
            $('.comment_delete_btn').click(function() {
                $commentId = $(this).find('.deleteCommentId').val();
                $data = {
                    'commentId': $commentId
                }
                $.ajax({
                    method: 'get',
                    url: '/user/comment/delete',
                    data: $data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : ""
                    }
                })
            })
            // $('.comment_edit_btn').click(function() {
            //     $commentId = $(this).find('.editCommentId').val();
            //     $data = {
            //         'commentId': $commentId
            //     }
            //     $.ajax({
            //         method: 'get',
            //         url: `/user/product/detail/${$productId}`,
            //         data: $data,
            //         dataType: 'json',
            //         success: function(res) {
            //             res.status == 'success' ? location.reload() : ""
            //         }
            //     })
            // })
        })
    </script>
@endsection
