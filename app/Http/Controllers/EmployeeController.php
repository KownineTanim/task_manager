<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;

class EmployeeController extends Controller
{
function EmployeeIndex(){
        return view('employee');	
}

function getEmployeeData(){
    $result=json_encode(EmployeeModel::orderBy('id','desc')->get());
    return $result;
}

function EmployeeAdd(Request $req){
    $employee_name = $req->input('employee_name');
    $employee_mail = $req->input('employee_mail');
    $employee_phone = $req->input('employee_phone');
    $employee_role = $req->input('employee_role');
    $result= EmployeeModel::insert([
        'employee_name'=>$employee_name,
        'employee_mail'=>$employee_mail,
        'employee_phone'=>$employee_phone,
        'employee_role'=>$employee_role,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function getEmployeeDetails(Request $req){
    $id= $req->input('id') ;
    $result=json_encode(EmployeeModel::where('id','=',$id)->get());
    return $result;
}

function EmployeeUpdate(Request $req){
    $id= $req->input('id');
    $employee_name = $req->input('employee_name');
    $employee_mail = $req->input('employee_mail');
    $employee_phone = $req->input('employee_phone');
    $employee_role = $req->input('employee_role');

    $result= EmployeeModel::where('id','=',$id)->update([
        'employee_name'=>$employee_name,
        'employee_mail'=>$employee_mail,
        'employee_phone'=>$employee_phone,
        'employee_role'=>$employee_role,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function EmployeeDelete(Request $req){
    $id= $req->input('id');
    $result= EmployeeModel::where('id','=',$id)->delete();

    if($result==true){      
      return 1;
    }
    else{
        return 0;
    }
}



}
