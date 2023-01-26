<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

use Hash;

class UserController extends Controller
{
  function index () {
    if(request()->has('json')) {
      $result = User::select('id', 'name', 'email', 'role_id', 'created_at')
        ->orderBy('id', 'desc')
        ->with('role')
        ->get();
      return response()->json($result);
    }
    return view('admin.user');	
  }

  function RoleList () {
    $result = Role::select('name','id')
      ->orderBy('id','asc')->get();
    return response()->json($result);
  }

  function store ( Request $req ) {
    $name = $req->input('name');
    $email = $req->input('email');
    $password = Hash::make($req->password);
    $role_id = $req->input('role_id');
    $result= User::insert([
      'name'=>$name,
      'email'=>$email,
      'password'=>$password,
      'role_id'=>$role_id,
    ]);
    return $result == true ? 1 : 0;
  }

  function getDetails ( Request $req ) {
    $id = $req->id;
    $result = User::with('role')
      ->find($id);
    return response()->json($result);
  }

  function delete ( Request $req ) {
    $id = $req->id;
    $result = User::where('id', $id)
      ->delete();
    return $result == true ? 1 : 0;
  }

}
