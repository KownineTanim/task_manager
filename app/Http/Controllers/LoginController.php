<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;

class LoginController extends Controller
{
    function LoginIndex(){
        return view('admin.login');	
    }

    function onLogin(Request $request){
        $credentials = $request->only(['email', 'password']);
        $credentials['role_id']='1';
        return  Auth::attempt($credentials) ? 1 : 0;
    }
    
    function onLogout(Request $request) {
        Auth::logout();
        return redirect('/admin');
    }
}
