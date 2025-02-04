<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductDetailController extends Controller
{
    //Detail Home Page
    public function detail($id)
    {

        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.description', 'products.stock', 'categories.name as category_name', 'products.stock', 'products.image')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)
            ->first();
        $relateProducts = Product::select('products.id', 'products.name', 'products.price', 'products.description', 'categories.name as category_name', 'products.stock', 'products.image')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('categories.name', $products['category_name'])
            ->where('products.id', '!=', $products['id'])
            ->get();
        $comments = Comment::select('comments.*', 'users.name', 'users.nickname', 'users.profile')
            ->leftJoin('users', 'comments.user_id', 'users.id')
            ->where('comments.product_id', $id)
            ->orderBy('comments.created_at', 'desc')
            ->get();
        $ratingAvg = Rating::where('product_id', $id)
            ->avg('count');
        $rating = Rating::where('product_id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        $ratingCount = $rating == null ? 0 : $rating->count;

        $allRating = Rating::get();
        $this->actionLog(Auth::user()->id, $id, 'seen');
        $actionLog = ActionLog::where('product_id', $id)->get();
        $viewTime = count($actionLog);
        return view('user.detail.detailPage', compact('cartNumber', 'products', 'relateProducts', 'comments', 'ratingAvg', 'ratingCount', 'allRating','viewTime'));
    }

    //Cart Page
    public function cartPage()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $carts = Cart::select('products.id as product_id', 'products.image', 'products.name', 'products.price', 'carts.qty', 'carts.id as cart_id')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->orderBy('carts.created_at', 'desc')
            ->get();
        $total = 0;
        foreach ($carts as $item) {
            $total += $item->price * $item->qty;
        }
        return view('user.cart.cartPage', compact('cartNumber', 'carts', 'total'));
    }
    //Cart Process
    public function cart(Request $request)
    {
        Cart::create([
            'product_id' => $request->productId,
            'user_id' => $request->userId,
            'qty' => $request->qty,
        ]);
        return to_route('homePage');
    }

    //Cart Delete
    public function cartDelete(Request $request)
    {
        $cartId = $request->cartId;
        Cart::where('id', $cartId)->delete();
        return response()->json([
            'status' => 'success',
            'message' => "cart delete successfully!"
        ], 200);
    }

    //Temporary Store Cart Data
    public function tempCart(Request $request)
    {
        $orderArr = [];
        foreach ($request->all() as $item) {
            $orderData = [
                'product_id' => $item['productId'],
                'user_id' => $item['userId'],
                'count' => $item['count'],
                'status' => 0,
                'order_code' => $item['orderCode'],
                'total_atm' => $item['totalAtm'],
            ];
            array_push($orderArr, $orderData);
        }
        Session::put('temp', $orderArr);
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    //Payment Page
    public function paymentPage()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $payment = Payment::orderBy('created_at', 'desc')
            ->get();
        $orderProduct = Session::get('temp');
        return view('user.payment.payment', compact('cartNumber', 'payment', 'orderProduct'));
    }

    //Order Process
    public function orderProcess(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'paymentType' => 'required',
            'payslipImage' => 'required',
        ]);

        //Add Data to Payment History table
        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_type' => $request->paymentType,
            'total_atm' => $request->totalAtm,
            'order_code' => $request->orderCode
        ];
        if ($request->hasFile('payslipImage')) {
            $fileName = uniqid() . $request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path() . "/payslip/", $fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);

        //order and clear cart
        $orderProduct = Session::get('temp');
        foreach ($orderProduct as $item) {
            $orderData = [
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item["count"],
                'status' => $item["status"],
                'order_code' => $item["order_code"],
            ];
            Order::create($orderData);

            //clear cart
            Cart::where('user_id', $item['user_id'])->where('product_id', $item['product_id'])->delete();
        }

        //go to order page
        return to_route('product#order');
    }

    public function orderPage()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $orderData = Order::where('user_id', Auth::user()->id)
            ->groupBy('order_code')
            ->get();

        return view('user.order.orderPage', compact('cartNumber', 'orderData'));
    }


    //Private function
    private function actionLog($user_id, $product_id, $action)
    {
        $actionLogData = [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'action' => $action,
        ];
        ActionLog::create($actionLogData);
    }
}
