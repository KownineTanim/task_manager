<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectListModel;
use App\Models\TaskModel;
use App\Models\EmployeeModel;
use App\Models\AssignmentModel;

class DashboardController extends Controller
{
	function DashboardIndex(){

        $TotalProject = ProjectListModel::count();
        $TotalTask = TaskModel::count();
        $TotalEmployee = EmployeeModel::count();
        $TotalAssignment = AssignmentModel::count();

 
         return view('dashboard',[
             'TotalProject'=>$TotalProject,
             'TotalTask'=>$TotalTask,
             'TotalEmployee' =>$TotalEmployee,
             'TotalAssignment'=>$TotalAssignment
         ]);
     }
}
