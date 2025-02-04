<?php

use App\Http\Controllers\Social\SocialController;
use Illuminate\Support\Facades\Route;


//social login    ->social == google || github

//redirect to social login
Route::get('/auth/{provider}/redirect',[SocialController::class, 'redirect'])->name('socialRedirect');

//callback from social login
Route::get('/auth/{provider}/callback',[SocialController::class, 'callback']);

