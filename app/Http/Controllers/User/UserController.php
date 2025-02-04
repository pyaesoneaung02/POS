<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //user home page
    public function home(Request $request)
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $category = Category::select('name', 'id')->get();
        $product = Product::select('categories.name as category_name', 'products.id', 'products.name', 'products.price', 'products.description', 'products.image')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            //filter by category name start ----->
            ->when(request('categoryId'), function ($query) {
                $query->where('products.category_id', request('categoryId'));
            })
            //filter by category name end------->

            //Filter by min price and max price  start------->
            //minPrice = true && maxPrice = true
            ->when(request('minPrice') && request('maxPrice'), function ($query) {
                $query = $query->where('products.price', '>=', request('minPrice'))->orderBy('products.price', 'asc');
                $query = $query->where('products.price', "<=", request('maxPrice'))->orderBy('products.price', 'asc');
            })
            //minPrice = true && maxPrice = false
            ->when(request('minPrice') && request('maxPrice') == null, function ($query) {
                $query = $query->where('products.price', '>=', request('minPrice'))
                    ->orderBy('products.price', 'asc');
            })
            //minPrice = false && maxPrice = true
            ->when(request('minPrice') == null && request('maxPrice'), function ($query) {
                $query = $query->where('products.price', '<=', request('maxPrice'))
                    ->orderBy('products.price', 'desc');
            })

            //Filter by min price and max price  end------->

            //Filter by searchKey start------>
            ->when(request('searchKey'), function ($query) {
                $query->where('products.name', 'like', '%' . request('searchKey') . '%');
            })
            //Filter by searchKey end------>

            //filter by sort start--->
            ->when($request->has('sortName') && $request->has('sortType'), function ($query) {
                $query->orderBy('products.' . request('sortName'), request('sortType'));
            })
            //filter by sort end--->

            //filter by create at of product without sort name and sort type
            ->when(!$request->has('sortName') && !$request->has('sortType'), function ($query) {
                $query->orderBy('products.created_at', 'desc');
            })
            ->get();
        return view('user.home.home', compact('cartNumber', 'product', 'category'));
    }
}
