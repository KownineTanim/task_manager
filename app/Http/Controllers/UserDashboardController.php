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
        $userId = Auth::user()->id;
        $TotalProject = Project::count();
        $TotalTask = Task::count();
        $TotalAssignment = TaskAssign::where('empoyee_id', $userId)->count();
         return view('employee.dashboard',[
             'TotalProject' => $TotalProject,
             'TotalTask' => $TotalTask,
             'TotalAssignment' => $TotalAssignment
         ]);
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
        $consumedTime = $req->consumed_time;
        $result = TaskAssign::where('id', $id) 
            ->update([
                'consumed_time' => \DB::raw('consumed_time + '. $consumedTime),
            ]);
        return $result == true ? 1 : 0;
    }
}
