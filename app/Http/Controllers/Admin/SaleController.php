<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //Sale Page
    public function salePage()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
            ->groupBy("order_code")
            ->get());
        $saleInfo = Order::select('orders.count', 'orders.order_code', 'orders.created_at', 'payment_histories.user_name as name', 'payment_histories.phone', 'payment_histories.address', 'payment_histories.total_atm as total_price')
            ->leftJoin('payment_histories', 'orders.order_code', 'payment_histories.order_code')
            ->where('orders.status', 1)
            ->groupBy('orders.order_code')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['orders.order_code', 'payment_histories.user_name', 'payment_histories.phone', 'payment_histories.address'], 'like', "%" . request('searchKey') . "%");
            })
            ->paginate(5);

        $toGetTotal = Order::select('payment_histories.total_atm as total_price')
            ->leftJoin('payment_histories', 'orders.order_code', 'payment_histories.order_code')
            ->where('orders.status', 1)
            ->groupBy('orders.order_code')
            ->get();
        $totalPrice = 0;
        foreach ($toGetTotal as $item) {
            $totalPrice += $item->total_price;
        }
        return view('admin.saleInfo.home', compact('saleInfo', 'totalPrice', 'pending_order'));
    }
}
