<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;

class UserLoginContoller extends Controller
{
    function LoginIndex(){
        return view('employee.login');	
    }

    function onLoginUser(Request $request){
        $credentials = $request->only(['email', 'password']);
        $credentials['role_id']='2';
        return  Auth::attempt($credentials) ? 1 : 0;
    }

    function onLogout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
