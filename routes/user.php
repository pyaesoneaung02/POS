<?php

use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {
    Route::get('home', [UserController::class, 'home'])->name('homePage');
    Route::prefix('profile')->group(function () {
        //profile page
        Route::get('profilePage', [ProfileController::class, 'profilePage'])->name('profile');

        //profile edit page
        Route::get('profileEdit', [ProfileController::class, 'profileEdit'])->name('profile#edit');
        //profile edit process
        Route::post('profileEdit', [ProfileController::class, 'profileEditProcess'])->name('profile#editProcess');
    });

    Route::get('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::post('changePassword', [ProfileController::class, 'changePasswordProcess'])->name('changePassword#process');

    Route::prefix('product')->group(function () {
        //product detail page
        Route::get('detail/{id}', [ProductDetailController::class, 'detail'])->name('product#detail');

        //cart Page
        Route::get('cart', [ProductDetailController::class, 'cartPage'])->name('product#cartPage');
        Route::post('cart', [ProductDetailController::class, 'cart'])->name('product#cart');

        //cart Delete
        Route::get('cart/delete', [ProductDetailController::class, 'cartDelete'])->name('product#cartDelete');
    });

    //temporary store Cart data
    Route::get('cart/temp', [ProductDetailController::class, 'tempCart'])->name('cart#temp');

    //Payment Route
    Route::get('/payment', [ProductDetailController::class, 'paymentPage'])->name('payment');

    //Order Process Route
    Route::post('/order', [ProductDetailController::class, 'orderProcess'])->name('product#orderProcess');

    //Order Page
    Route::get('/order', [ProductDetailController::class, 'orderPage'])->name('product#order');

    //Comment Page
    Route::post('/comment', [CommentController::class, 'comment'])->name('comment');
    //Delete comment
    Route::get('/comment/delete', [CommentController::class, 'commentDelete'])->name('comment#delete');

    //Rating Process
    Route::post('/rating', [RatingController::class, 'ratingProcess'])->name('ratingProcess');

    //Contact route
    Route::get('/contact',[ContactController::class,'contactPage'])->name('contactPage');
    Route::post('/contact',[ContactController::class,'contactProcess'])->name('contactPage#contact');
});
