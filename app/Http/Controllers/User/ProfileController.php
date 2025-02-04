<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //Profile page
    public function profilePage()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $profileData = User::where('id', Auth::user()->id)->first();
        return view('user.profile.profile', compact('profileData', 'cartNumber'));
    }

    //Profile edit
    public function profileEdit()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        $profileData = User::where('id', Auth::user()->id)->first();
        return view('user.profile.updateProfile', compact('cartNumber', 'profileData'));
    }

    //profile edit process
    public function profileEditProcess(Request $request)
    {
        $this->profileValidation($request);
        $updateData = $this->profileUpdateData($request);
        if ($request->hasFile('image')) {
            //delete old image
            if (Auth::user()->profile != null) {
                if (file_exists(public_path('profile/', Auth::user()->profile))) {
                    unlink(public_path('profile/' . Auth::user()->profile));
                }
            }
            //store new image
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/profile', $fileName);
            $updateData['profile'] = $fileName;
        } else {
            $updateData['profile'] = Auth::user()->profile;
        }
        User::where('id', Auth::user()->id)->update($updateData);
        Alert::success('Successfully!', 'Updated Profile is Successfully!');
        return to_route('homePage');
    }

    //change password page
    public function changePassword()
    {
        $cartNumber = count(Cart::where('user_id', Auth::user()->id)->get());
        return view('user.changePassword.changePasswordPage', compact('cartNumber'));
    }

    public function changePasswordProcess(Request $request)
    {
        $this->passwordValidation($request);
        $oldPassword = Auth::user()->password;
        $currentPassword = $request->currentPassword;
        $newPassword = $request->newPassword;
        if (Hash::check($currentPassword, $oldPassword)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($newPassword)
            ]);
            Alert::success('Successfully!', 'change password is successfully👌');
            return to_route("homePage");
        } else {
            return back()->withErrors(['currentPassword' => 'The current password is incorrect.']);
        }
        dd($oldPassword, $currentPassword, $newPassword);
    }

    //private routes

    //profile data
    private function profileUpdateData($request)
    {
        return [
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
    //profile validation
    private function profileValidation($request)
    {
        $validationRule = [
            'image' => 'mimes:jpg,jpeg,svg,bmp,png',
            'name' => 'required',
            'nickname' => 'required',
            'email' => 'required|unique:users,email,' . Auth::user()->id,
            'phone' => 'required',
            'address' => 'required'
        ];
        $request->validate($validationRule);
    }

    //password validation
    private function passwordValidation($request)
    {
        $validationRule = [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|same:newPassword'
        ];
        $request->validate($validationRule);
    }
}
