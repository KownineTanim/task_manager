<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    function index () {
        if(request()->has('json')) {
            $result = Task::select('id', 'title', 'description', 'project_id', 'created_by', 'created_at')
                ->with(['projectname', 'username'])
                ->get();
            return response()->json($result);
        }
        return view('admin.task');	
    }

    function ProjectList () {
        $result = Project::select('name','id')
            ->orderBy('id','asc')
            ->get();
        return response()->json($result);
    }

    function store (Request $req) {
        $title = $req->input('title');
        $description = $req->input('description');
        $project_id = $req->input('project_id');
        $user_id = $req->session()->get('id');
        $result= Task::insert([
            'title'=>$title,
            'description'=>$description,
            'project_id'=>$project_id,
            'created_by'=>$user_id,
        ]);
        return $result == true ? 1 : 0;
    }

    function getDetails (Request $req) {
        $id = $req->id;
        $result = Task::with('projectname')
            ->find($id);
        return response()->json($result);
    }

    function update (Request $req) {
        $id = $req->id;
        $title = $req->input('title');
        $description = $req->input('description');
        $project_id = $req->input('project_id');
        $user_id = $req->session()->get('id');
        $result= Task::where('id','=',$id)->update([
            'title' => $title,
            'description' => $description,
            'project_id' => $project_id,
            'created_by' => $user_id,
        ]);
        return $result == true ? 1 : 0;
    }

    function delete (Request $req){
        $id = $req->id;
        $result = Task::where('id', $id)
            ->delete();
        return $result == true ? 1 : 0;
    }
}
