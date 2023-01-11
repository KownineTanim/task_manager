<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskModel;
use App\Models\EmployeeModel;
use App\Models\AssignmentModel;

class AssignmentController extends Controller
{
function AssignmentIndex(){
    return view('assignment');	
}

function getAssignmentData(){

    $result=json_encode(AssignmentModel::with('project')->with('task')->get());
    return $result;
      
}

function projectWiseTask(Request $req){
        
    $project_id= $req->input('project_id');
    $result=json_encode(TaskModel::where('project_id','=',$project_id)->get());
    return $result; 
}

function EmployeeList(){

    $result=json_encode(EmployeeModel::select('employee_name','id')->orderBy('id','asc')->get());
    return $result;
}

function AssignmentAdd(Request $req){
    $project_id = $req->input('project_id');
    $task_id = $req->input('task_id');
    $employee_id = $req->input('employee_id');
    $assign_date = $req->input('assign_date');
    $dateFrom = Date('Y-m-d', strtotime($assign_date));
    $end_date = $req->input('end_date');
    $dateTo = Date('Y-m-d', strtotime($end_date));
    $result= AssignmentModel::insert([
        'project_id'=>$project_id,
        'task_id'=>$task_id,
        'employee_id'=>$employee_id,
        'assign_date'=>$dateFrom,
        'end_date'=>$dateTo,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }

}

}
