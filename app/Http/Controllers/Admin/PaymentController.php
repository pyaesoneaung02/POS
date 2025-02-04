<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //read
    public function read()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $paymentData=Payment::orderByDesc('created_at')->paginate(4);
        return view('admin.payments.paymentPage',compact('paymentData','pending_order'));
    }

    //create
    public function create(Request $request)
    {
        $this->paymentValidation($request);
        $data=$this->paymentData($request);
        Payment::create($data);
        Alert::success('Successfully', 'Create Payment is successfully!');
        return to_route('payment#paymentPage');
    }

    //update
    public function updatePage($id){
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $paymentData = Payment::find($id);
        return view('admin.payments.paymentUpdatePage',compact('paymentData','pending_order'));
    }
    public function updateProcess(Request $request , $id){
        $this->paymentValidation($request);
        $data=$this->paymentData($request);
        Payment::find($id)->update($data);
        Alert::success('Successfully', 'Update Payment is successfully!');
        return to_route('payment#paymentPage');
    }

    //delete
    public function delete($id){
        Payment::find($id)->delete();
        Alert::success('Successfully', 'Payment delete is successfully!');
        return to_route('payment#paymentPage');
    }


    //private
    private function paymentData($request){
           return [
           'account_number' => $request->accountNumber,
           'account_name' => $request->accountName,
           'type'=>$request->paymentType,
           ];
    }
    private function paymentValidation($request){
        $validationRule=[
           'accountNumber'=>'required|numeric',
           'accountName'=>'required|min:6|max:30',
           'paymentType'=>'required',
        ];
        $request->validate($validationRule);
    }
}
