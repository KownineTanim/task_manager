<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    function index () {
        if(request()->has('json')) {
            $result = Project::orderBy('id', 'desc')
                ->with('user')
                ->get();
            return response()->json($result);
        }
        return view('admin.project');	
    }
        
    function store (Request $req) {
        $name = $req->name;
        // $userId = auth()->id();
        $userId = $req->session()->get('id');
        $result= Project::insert([
            'name' => $name,
            'created_by' => $userId,
        ]);
        return $result == true ? 1 : 0;
    }

    function getDetails (Request $req) {
        $id = $req->id;
        $result = Project::find($id);
        return response()->json($result);
    }

    function update (Request $req) {
        $id = $req->id;
        $project_name = $req->name;
        $userId = $req->session()->get('id');
        $result = Project::where('id', $id)
            ->update([
                'name' => $project_name,
                'created_by' => $userId,
            ]);
        return $result == true ? 1 : 0;
    }

    function delete (Request $req){
        $id = $req->id;
        $result = Project::where('id', $id)
            ->delete();
        return $result == true ? 1 : 0;
    }
}
