<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //Content Page
    public function contactPage()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $contacts = Contact::select('contacts.*', 'users.name', 'users.nickname')
            ->leftJoin('users', 'contacts.user_id', 'users.id')
            ->paginate(2);
        return view('admin.contact.contactPage', compact('contacts','pending_order'));
    }
}
