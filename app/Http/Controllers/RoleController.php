<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    function index () {
        if(request()->has('json')) {
            $result = Role::orderBy('id', 'desc')
                ->get();
            return response()->json($result);
        }
        return view('admin.user_role');	
    }

    function store ( Request $req ) {
        $name = $req->input('name');
        $status = $req->input('status');
        $result= Role::insert([
            'name'=>$name,
            'status'=>$status,
        ]);
        return $result == true ? 1 : 0;
    }

    function getDetails (Request $req) {
        $id = $req->id;
        $result = Role::find($id);
        return response()->json($result);
    }

    function update (Request $req) {
        $id = $req->id;
        $role_name = $req->name;
        $role_status = $req->status;
        $result = Role::where('id', $id)
            ->update([
                'name' => $role_name,
                'status' => $role_status,
            ]);
        return $result == true ? 1 : 0;
    }

    function delete (Request $req){
        $id = $req->id;
        $result = Role::where('id', $id)
            ->delete();
        return $result == true ? 1 : 0;
    }
}
