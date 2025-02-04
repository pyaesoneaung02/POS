<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //Rating Process
    public function ratingProcess(Request $request)
    {
        Rating::updateOrCreate([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
        ], [
            'count' => $request->productRating
        ]);

        return back();
    }
}
