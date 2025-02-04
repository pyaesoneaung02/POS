<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SaleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    //dashboard route
    Route::get('dashboard', [AdminController::class, 'adminDashboard'])->name('adminDashboard');

    //category route
    Route::group(['prefix' => 'category'], function () {
        //list route
        Route::get("list", [CategoryController::class, 'list'])->name("category#list");

        //create route
        Route::post("list", [CategoryController::class, 'create'])->name('category#create');

        //update
        Route::get('update/{id}', [CategoryController::class, 'updatePage'])->name('category#updatePage');
        //update process
        Route::post('update/{id}', [CategoryController::class, 'updateProcess'])->name('category#updateProcess');

        //delete
        Route::get('delete/{id}', [CategoryController::class, 'deleteProcess'])->name('category#delete');
    });


    Route::group(['prefix' => 'profile'], function () {
        //profile route
        Route::get('profilePage', [ProfileController::class, 'profilePage'])->name('profile#profilePage');
        //profile edit route
        Route::get('profileEdit', [ProfileController::class, 'profileEditPage'])->name('profile#profileEditPage');
        Route::post('profileEdit', [ProfileController::class, 'profileEditPageProcess'])->name('profile#profileEditPageProcess');

        Route::group(['middleware' => 'superAdmin'], function () {
            //Create new admin route
            Route::get('createAdminPage', [ProfileController::class, 'createAdminPage'])->name('profile#createAdminPage');
            Route::post('createAdmin', [ProfileController::class, 'createAdminProcess'])->name('profile#createAdminProcess');

            //view create admin account and superAdmin account
            Route::get('adminAccounts', [ProfileController::class, 'viewAdminAccounts'])->name('profile#adminAccounts');
            //delete admin account
            Route::get('adminAccountDelete/{id}', [ProfileController::class, 'deleteAdminAccount'])->name('adminAccount#delete');

            //view user account
            Route::get('userAccounts', [ProfileController::class, 'viewUserAccounts'])->name('profile#userAccounts');
            //delete user account
            Route::get('userAccountDelete/{id}', [ProfileController::class, 'deleteUserAccount'])->name('account#delete');
        });

        //change password route
        Route::get("changePassword", [ProfileController::class, 'changePassword'])->name("profile#changePassword");
        Route::post("changePassword", [ProfileController::class, 'changePasswordProcess'])->name("profile#changePasswordProcess");
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('paymentPage', [PaymentController::class, 'read'])->name('payment#paymentPage');
        Route::post('paymentCrete', [PaymentController::class, 'create'])->name('payment#paymentCreate');

        Route::get('paymentUpdate/{id}', [PaymentController::class, 'updatePage'])->name('payment#paymentUpdatePage');
        Route::post('paymentUpdate/{id}', [PaymentController::class, 'updateProcess'])->name('payment#paymentUpdateProcess');

        Route::get('paymentDelete/{id}', [PaymentController::class, 'delete'])->name('payment#paymentDelete');
    });

    //Product Route
    Route::group(['prefix' => 'product', 'middleware' => 'superAdmin'], function () {
        //Create Product Page route
        Route::get('create', [ProductController::class, 'createPage'])->name('product#createPage');
        Route::post('create', [ProductController::class, 'createProcess'])->name('product#createProcess');

        //View Product route
        Route::get('view/{slt5?}', [ProductController::class, 'viewPage'])->name('product#viewProduct');

        //Product Edit route
        Route::get('updatePage/{id}', [ProductController::class, 'productUpdatePage'])->name('product#updatePage');
        Route::post('updatePage', [ProductController::class, 'productUpdateProcess'])->name('product#updateProcess');
        //Product Delete route
        Route::get('delete/{id}', [ProductController::class, 'productDelete'])->name('product#delete');
        //detail route
        Route::get('detail/{id}', [ProductController::class, 'productDetail'])->name('product#detailPage');
    });

    //Order Route
    Route::group(['prefix' => 'order', 'middleware' => 'superAdmin'], function () {
        //Order Page route
        Route::get('order', [OrderController::class, 'orderPage'])->name('orderPage');

        //change Status process
        Route::get('statusChange', [OrderController::class, 'statusChange']);

        //show Order detail route
        Route::get('detail/{orderCode}', [OrderController::class, 'orderDetail'])->name('order#detail');

        //Order confirm button process
        Route::get('confirm', [OrderController::class, 'confirm']);
        //Order cancel button process
        Route::get('cancel', [OrderController::class, 'cancel']);
    });

    //Content Route
    Route::get('contact', [ContactController::class, 'contactPage'])->name('contact');

    //Sale Route
    Route::get('sale',[SaleController::class, 'salePage'])->name('salePage');
});
