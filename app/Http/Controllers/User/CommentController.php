<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Comment Process
    public function comment(Request $request)
    {
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => $request->userId,
            'message' => $request->comment,
        ]);
        return back();
    }

    //Delete Comment process
    public function commentDelete(Request $request)
    {
        Comment::where('id', $request->commentId)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "Comment delete successfully!"
        ], 200);
    }
}
