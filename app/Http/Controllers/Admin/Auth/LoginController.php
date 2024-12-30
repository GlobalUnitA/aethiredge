<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
     
    }

    public function index()
    {
        return view('admin.auth.login');
    }


    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin');
        }

        return redirect()->route('admin.login')->withErrors('Invalid credentials.');
    }

    public function logout()
    {
    
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}