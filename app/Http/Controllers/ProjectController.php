<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectListModel;

class ProjectController extends Controller
{
function ProjectIndex(){
        return view('project');	
}

function getProjectData(){
         $result=json_encode(ProjectListModel::orderBy('id','desc')->get());
         return $result;
}
    
function ProjectAdd(Request $req){
    $project_name= $req->input('project_name');
    $project_desc= $req->input('project_desc');
    $result= ProjectListModel::insert([
        'project_name'=>$project_name,
        'project_desc'=>$project_desc,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function getProjectDetails(Request $req){
    $id= $req->input('id');
    $result=json_encode(ProjectListModel::where('id','=',$id)->get());
    return $result;
}

function ProjectUpdate(Request $req){
    $id= $req->input('id');
    $project_name= $req->input('project_name');
    $project_desc= $req->input('project_desc');

    $result= ProjectListModel::where('id','=',$id)->update([
        'project_name'=>$project_name,
        'project_desc'=>$project_desc,
    ]);

    if($result==true){      
      return 1;
    }
    else{
     return 0;
    }
}

function ProjectDelete(Request $req){
    $id= $req->input('id');
    $result= ProjectListModel::where('id','=',$id)->delete();

    if($result==true){      
      return 1;
    }
    else{
        return 0;
    }
}


}
