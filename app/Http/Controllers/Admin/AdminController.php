<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //admin home page
    public function adminDashboard()
    {
        //user  and admin accounts
        $admins = User::select('id')->where('role', 'admin')->get();
        $users = User::select('id')->where('role', 'user')->get();

        //total amount
        $totalAmount = Order::select('orders.id', 'payment_histories.total_atm as total_price')
            ->leftJoin('payment_histories', 'orders.order_code', 'payment_histories.order_code')
            ->where('orders.status', '!=', 2)
            ->groupBy('orders.order_code')
            ->get();

        $totalPrice = 0;
        foreach ($totalAmount as $item) {
            $totalPrice += $item->total_price;
        }

        //sale order
        // $order = ;
        $all_order = count(Order::select('id')
            ->groupBy("order_code")
            ->get());
        $pending_order = count(Order::select('id')->where('status', 0)
            ->groupBy("order_code")
            ->get());
        $sale_order = count(Order::select('id')->where('status', 1)
            ->groupBy("order_code")
            ->get());
        $cancel_order = count(Order::select('id')->where('status', 2)
            ->groupBy("order_code")
            ->get());

        //comment
        $comments = count(Comment::select("id")->get());

        //comment
        $contacts = count(Contact::select("id")->get());
        return view('admin.home.home', compact('users', 'admins', 'totalPrice', 'comments', 'contacts', 'all_order', 'sale_order', 'cancel_order','pending_order'));
    }
}
