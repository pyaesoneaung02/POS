<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    //Contact Page
    public function contactPage()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        return view('user.contact.home', compact('cartNumber'));
    }
    //Contact Process
    public function contactProcess(Request $request)
    {
        $createData = [
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message
        ];
        Contact::create($createData);
        Alert::success('Successfully!', 'CContact is Successfully!');
        return to_route('contactPage');
    }
}
