<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAssign;
use Auth;

class UserDashboardController extends Controller
{
    function index () {
        $TotalProject = Project::count();
        $TotalTask = Task::count();
        $TotalAssignment = TaskAssign::count();
         return view('employee.dashboard',[
             'TotalProject' => $TotalProject,
             'TotalTask' => $TotalTask,
             'TotalAssignment' => $TotalAssignment
         ]);
    }

    function projectIndex () {
        if(request()->has('json')) {
            $result = Project::with('user')
                ->get();
            return response()->json($result);
        }
        return view('employee.project');	
    }

    function taskIndex () {
        if(request()->has('json')) {
            $result = Task::select('id', 'title', 'description', 'project_id', 'created_by', 'created_at')
                ->with(['projectname', 'username'])
                ->get();
            return response()->json($result);
        }
        return view('employee.task');	
    }

    function assignmentIndex () {
        if(request()->has('json')) {
            $userId = Auth::user()->id;
            $result = TaskAssign::select('id', 'empoyee_id', 'task_id', 'consumed_time', 'assigned_by', 'created_at')
                ->with(['employee', 'taskname', 'user'])
                ->orderBy('id', 'desc')
                ->where('empoyee_id', $userId)
                ->get();
            return response()->json($result);
        }
        return view('employee.assignment');	
    }

    function assignmentStart (Request $req) {
        $id = $req->id ;
        $consumed_time = $req->consumed_time;
        $previous_time = TaskAssign::select('consumed_time')
                ->where('id', $id)
                ->first();
        $pre_consume = $previous_time->consumed_time ;
        $total = $pre_consume +  $consumed_time;
        $result = TaskAssign::where('id', $id) 
            ->update([
                'consumed_time' => $total,
            ]);
        return $result == true ? 1 : 0;
    }
}
