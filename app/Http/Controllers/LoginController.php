<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class LoginController extends Controller
{
    function LoginIndex(){
        return view('login');	
    }
    function onLogin(Request $request){
        $email= $request->input('email');
        $password= $request->input('password');
        $md5 = md5($password);
        
        $user= UserModel::where('email','=',$email)->first();
        
        
        if ($user){
            $dbPassword = UserModel::where('email','=',$email)->pluck('password')->first();
            if($md5 === $dbPassword){
                $request->session()->put('email', $email);
                return 1 ;
                
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }

 
    }
    function onLogout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
