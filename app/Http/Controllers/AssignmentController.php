<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskAssign;

class AssignmentController extends Controller
{
    function index () {
        if(request()->has('json')) {
            $result = TaskAssign::select('id', 'empoyee_id', 'task_id', 'consumed_time', 'assigned_by', 'created_at')
                ->with(['employee', 'taskname', 'adminname'])
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($result);
        }
        return view('admin.assignment');	
    }

    function EmployeeList () {
        $result = User::select('name','id')
            ->orderBy('id','asc')
            ->get();
        return response()->json($result);
    }

    function TaskList () {
        $result = Task::select('title','id')
            ->orderBy('id','asc')
            ->get();
        return response()->json($result);
    }

    function store (Request $req) {
        $task_id = $req->input('task_id');
        $employee_id = $req->input('empoyee_id');
        $ini_time = 0;
        $user_id = $req->session()->get('id');
        $result= TaskAssign::insert([
            'empoyee_id' => $employee_id,
            'task_id' => $task_id,
            'consumed_time' => $ini_time,
            'assigned_by' => $user_id,
        ]);
        return $result == true ? 1 : 0;
    }

    function getDetails(Request $req) {
        $id = $req->id;
        $result=TaskAssign::with(['employee', 'taskname', 'adminname'])
            ->find($id);
        return response()->json($result);
    }

    function update (Request $req) {
        $id = $req->id;
        $empoyee_id = $req->input('empoyee_id');
        $task_id = $req->input('task_id');
        $ini_time = 0;
        $user_id = $req->session()->get('id');
        $result= TaskAssign::where('id','=',$id)->update([
            'empoyee_id' => $empoyee_id,
            'task_id' => $task_id,
            'consumed_time' => $ini_time,
            'assigned_by' => $user_id ,
        ]);
        return $result == true ? 1 : 0;
    }

    function delete(Request $req) {
        $id = $req->id;
        $result= TaskAssign::where('id','=',$id)
            ->delete();
        return $result == true ? 1 : 0;
    }
}
