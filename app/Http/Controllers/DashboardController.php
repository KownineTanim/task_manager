<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\Role;
use App\Models\User;
use App\Models\TaskAssign;

class DashboardController extends Controller
{
	function index () {
        $TotalProject = Project::count();
        $TotalTask = Task::count();
        $TotalRole = Role::count();
        $TotalUser = User::count();
        $TotalAssignment = TaskAssign::count();
         return view('admin.dashboard',[
             'TotalProject' => $TotalProject,
             'TotalTask' => $TotalTask,
             'TotalRole' => $TotalRole,
             'TotalUser' => $TotalUser,
             'TotalAssignment' => $TotalAssignment
         ]);
    }
}
