<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectListModel;
use App\Models\TaskModel;

class TaskController extends Controller
{
function TaskIndex(){
        return view('task');	
}

function getTaskData(){

    $result=json_encode(TaskModel::with('project')->get());
    return $result;
      
}

function ProjectList(){

    $result=json_encode(ProjectListModel::select('project_name','id')->orderBy('id','asc')->get());
    return $result;
}

function TaskAdd(Request $req){
    $project_id = $req->input('project_id');
    $task_name = $req->input('task_name');
    $task_desc = $req->input('task_desc');
    $result= TaskModel::insert([
        'project_id'=>$project_id,
        'task_name'=>$task_name,
        'task_desc'=>$task_desc,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function getTaskDetails(Request $req){
    $id= $req->input('id') ;
    $result=json_encode(TaskModel::with('project')->where('id','=',$id)->get());
    return $result;
}

function TaskUpdate(Request $req){
    $id= $req->input('id');
    $project_id = $req->input('project_id');
    $task_name = $req->input('task_name');
    $task_desc = $req->input('task_desc');

    $result= TaskModel::where('id','=',$id)->update([
        'project_id'=>$project_id,
        'task_name'=>$task_name,
        'task_desc'=>$task_desc,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function TaskDelete(Request $req){
    $id= $req->input('id');
    $result= TaskModel::where('id','=',$id)->delete();

    if($result==true){      
      return 1;
    }
    else{
        return 0;
    }
}

}
