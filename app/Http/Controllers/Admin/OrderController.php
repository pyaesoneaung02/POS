<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Product;

class OrderController extends Controller
{
    //Order Page
    public function orderPage()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $orders = Order::select('orders.id', 'orders.created_at', 'orders.order_code', 'orders.status', 'users.name', 'users.nickname')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->groupBy('orders.order_code')
            ->orderBy('orders.created_at', 'desc')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['orders.order_code', 'users.name'], 'like', '%' . request('searchKey') . "%");
            })
            ->paginate(5);
        return view('admin.orders.orderPage', compact('orders','pending_order'));
    }

    //order change status
    public function statusChange(Request $request)
    {
        Order::where('order_code', $request->orderCode)->update([
            'status' => $request->status
        ]);
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    //Show Detail Page
    public function orderDetail(Request $request, $orderCode)
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $order = Order::select('orders.order_code', 'orders.created_at', 'orders.count', 'orders.product_id', 'orders.status', 'users.name', 'users.nickname', 'users.address', 'users.phone', 'products.image', 'products.name as product_name', 'products.stock', 'products.price')
            ->leftJoin('users', 'orders.user_id', 'users.id')
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->where('orders.order_code', $orderCode)
            ->get();
        $paymentHistory = PaymentHistory::where('order_code', $orderCode, 'payment_histories.order_code')
            ->first();
        $confirmStatus = [];
        $status = true;
        foreach ($order as $item) {
            array_push($confirmStatus, $item->stock < $item->count ? false : true);
        };
        foreach ($confirmStatus as $item) {
            if ($item == false) {
                $status = false;
                break;
            }
        }
        return view('admin.orders.orderDetailPage', compact('order', 'paymentHistory', 'status','pending_order'));
    }

    //Order Confirm Process
    public function confirm(Request $request)
    {
        Order::where('order_code', $request[0]['order_code'])->update([
            'status' => 1
        ]);

        foreach ($request->all() as $item) {
            Product::where('id', $item['product_id'])->decrement('stock', $item['order_count']);
        }

        return response()->json([
            'status' => 'success'
        ], 200);
    }
    //Order Cancel Process
    public function cancel(Request $request)
    {
        Order::where('order_code', $request->order_code)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
