<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    //Login ui
    public function create()
    {
        return view("authentication.login.login");
    }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin') {
            return to_route('adminDashboard');
        }
         if (Auth::user()->role == "user") {
            return to_route('homePage');
        }
    }

    //logout process
    public function destroy(Request $request):RedirectResponse{
      Auth::guard('web')->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return  redirect('/');
    }
}
