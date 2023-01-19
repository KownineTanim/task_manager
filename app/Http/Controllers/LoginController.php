<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    function LoginIndex(){
        return view('admin.login');	
    }

    function onLogin(Request $request){
        $email= $request->input('email');
        $password= $request->input('password');
        $md5 = md5($password);
        $user= User::where('email','=',$email)->first();
        if ($user){
            $dbPassword = User::where('email',$email)->pluck('password')->first();
            $role = User::where('email',$email)->pluck('role_id')->first();
            if($md5 === $dbPassword && $role == 1){
                $UserInfo = User::where('email',$email)->pluck('id')->first();
                $request->session()->put('id', $UserInfo);
                $request->session()->put('email', $email);
                return 1 ;
                
            } else{
                return 0;
            }
        } else {
            return 0;
        }
    }
    
    function onLogout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
