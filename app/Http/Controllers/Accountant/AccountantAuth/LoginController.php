<?php

namespace App\Http\Controllers\Accountant\AccountantAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;

class LoginController extends Controller
{
    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    public $redirectTo = '/accountant/home';


    public function __construct()
    {
        session(['lang' => 'ar']);
        app()->setLocale('ar');
        $this->middleware('accountant.guest', ['except' => 'logout']);
    }


    public function showLoginForm()
    {
        return view('accountant.auth.login');
    }


    public function username()
    {
        return 'email';
    }

    protected function authenticated(Request $request, $user)
    {

//        dd(checkRequestIsWorkingOrNot(),$user);
    }


    protected function guard()
    {
        return Auth::guard('accountant');
    }
}
