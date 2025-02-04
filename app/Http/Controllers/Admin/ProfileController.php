<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{

    //profile page
    public function profilePage()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
            ->groupBy("order_code")
            ->get());
        return view('admin.profile.profilePage',compact('pending_order'));
    }
    //profile edit page
    public function profileEditPage() //profile view page
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        return view('admin.profile.profileEditPage',compact('pending_order'));
    }
    public function profileEditPageProcess(Request $request) //profile edit page process
    {
        $this->profileEditCheckValidation($request);
        $data = $this->profileEditData($request);
        if ($request->hasFile('image')) {
            //delete old image
            if (Auth::user()->profile !== null) {
                if (file_exists(public_path('profile/', Auth::user()->profile))) {
                    unlink(public_path('profile/' . Auth::user()->profile));
                }
            }

            //strong new image
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $quidFileName = uniqid() . $fileName;
            $file->move(public_path() . '/profile', $quidFileName);
            $data['profile'] = $quidFileName;
        } else {
            $data['profile'] = Auth::user()->profile;
        }
        User::where('id', Auth::user()->id)->update($data);
        Alert::success('Updated Success', 'Updated Profile is Successfully!');
        return to_route('profile#profilePage');
    }
    public function createAdminPage() //create admin view page
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        return view('admin.profile.createAdmin',compact('pending_order'));
    }
    public function createAdminProcess(Request $request) //crete admin process
    {
        $this->checkCreateAdminValidation($request);
        $createAdminData = $this->createAdminData($request);
        User::create($createAdminData);
        Alert::success('Created Admin Account', 'Created Admin Account is Successfully!');
        return to_route('profile#adminAccounts');
    }
    public function changePassword() //change password view page
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        return view('admin.profile.changePasswordPage',compact('pending_order'));
    }
    public function changePasswordProcess(Request $request)   //change password process
    {
        $this->checkChangePasswordValidation($request);
        $id = Auth::user()->id;
        $currentPassword = Auth::user()->password;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        if (Hash::check($oldPassword, $currentPassword)) {
            User::where('id', $id)->update([
                'password' => Hash::make($newPassword)
            ]);

            Alert::success('Success', 'change password is Successfully!');
            return to_route('getCustomLogout');
        } else {
            Alert::error('Error', 'old Password do not match current password? Try again...');
            return back();
        }
    }

    //see create admin accounts and superAdmin account
    public function viewAdminAccounts()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $accounts = User::select('id', 'name', 'email', 'address', 'phone', 'role', 'created_at')
            ->whereIn('role', ['superAdmin', 'admin'])
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'role'], 'like', '%' . request('searchKey') . "%");
            })
            ->orderByDesc('created_at')
            ->paginate(4);
        return view('admin.profile.adminListPage', compact('accounts','pending_order'));
    }

    //delete admin account
    public function deleteAdminAccount($id)
    {
        User::where('id', $id)->delete();
        Alert::success('Successfully', 'delete Admin account is successfully!');
        return to_route('profile#adminAccounts');
    }

    //see create admin accounts and superAdmin account
    public function viewUserAccounts()
    {
        $pending_order = count(Order::select('id')->where('status', 0)
        ->groupBy("order_code")
        ->get());
        $accounts = User::select('id', 'name', 'email', 'address', 'phone', 'role', 'provider', 'created_at')
            ->whereIn('role', ['user'])
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'email', 'address', 'phone', 'role', 'provider'], 'like', '%' . request('searchKey') . "%");
            })
            ->orderByDesc('created_at')
            ->paginate(4);
        return view('admin.profile.userListPage', compact('accounts','pending_order'));
    }

    //delete admin account
    public function deleteUserAccount($id)
    {
        User::where('id', $id)->delete();
        Alert::success('Successfully', 'delete user account is successfully!');
        return to_route('profile#userAccounts');
    }

    //private routes
    //validation process
    private function profileEditData($request)  //profile edit form data
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
    private function profileEditCheckValidation($request) //profile edit validation
    {
        $validationRule = [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|min:8|max:15|unique:users,phone,' . Auth::user()->id,
            'address' => 'required',
            'image' => 'mimes:jpg,png,jpeg,svg|file'
        ];
        $request->validate($validationRule);
    }
    private function createAdminData($request) //create admin form data
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ];
    }
    private function checkCreateAdminValidation($request) //create admin validation
    {
        $validationRule = [
            'name' => 'required|min:3|max:30',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|max:16',
            'confirm_password' => 'required|same:password'
        ];
        $request->validate($validationRule);
    }

    private function checkChangePasswordValidation($request) //change password validation
    {
        $validationRule = [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max: 15',
            'confirmPassword' => 'required|same:newPassword'
        ];
        $validationMessage = [
            'oldPassword.required' => 'စကားဝှက်အဟောင်း လိုအပ်သည်။',
            'newPassword.required' => 'စကားဝှက်အသစ် လိုအပ်သည်။',
            'newPassword.min' => 'စကားဝှက်အသစ်တွင် အနည်းဆုံး စာလုံး 6 လုံးရှိရမည်။',
            'newPassword.max' => 'စကားဝှက်အသစ်သည် စာလုံး 15 လုံးထက် မပိုရပါ။',
            'confirmPassword.required' => 'အတည်ပြုစကားဝှက်အကွက် လိုအပ်သည်။',
            'confirmPassword.same' => 'အတည်ပြုစကားဝှက်သည် စကားဝှက်အသစ်နှင့် ကိုက်ညီရပါမည်။',

        ];
        $request->validate($validationRule, $validationMessage);
    }
}
