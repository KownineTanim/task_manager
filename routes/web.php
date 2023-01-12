<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     return view('login');
// });
//Login route
Route::get('/', [LoginController::class, 'LoginIndex']);
Route::post('/onLogin', [LoginController::class, 'onLogin']);
Route::get('/onLogout', [LoginController::class, 'onLogout']);


//Dashboard route
Route::get('/Dashboard', [DashboardController::class, 'DashboardIndex'])->middleware('LoginCheck')->middleware('PreventBack');

//Project route
Route::get('/ProjectIndex', [ProjectController::class, 'ProjectIndex'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/getProjectData', [ProjectController::class, 'getProjectData'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/ProjectAdd', [ProjectController::class, 'ProjectAdd'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/getProjectDetails', [ProjectController::class, 'getProjectDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/ProjectUpdate', [ProjectController::class, 'ProjectUpdate'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/ProjectDelete', [ProjectController::class, 'ProjectDelete'])->middleware('LoginCheck')->middleware('PreventBack');

//Task route
Route::get('/TaskIndex', [TaskController::class, 'TaskIndex'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/getTaskData', [TaskController::class, 'getTaskData'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/ProjectList', [TaskController::class, 'ProjectList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/TaskAdd', [TaskController::class, 'TaskAdd'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/getTaskDetails', [TaskController::class, 'getTaskDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/TaskUpdate', [TaskController::class, 'TaskUpdate'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/TaskDelete', [TaskController::class, 'TaskDelete'])->middleware('LoginCheck')->middleware('PreventBack');

//Employee route
Route::get('/EmployeeIndex', [EmployeeController::class, 'EmployeeIndex'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/getEmployeeData', [EmployeeController::class, 'getEmployeeData'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/EmployeeAdd', [EmployeeController::class, 'EmployeeAdd'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/getEmployeeDetails', [EmployeeController::class, 'getEmployeeDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/EmployeeUpdate', [EmployeeController::class, 'EmployeeUpdate'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/EmployeeDelete', [EmployeeController::class, 'EmployeeDelete'])->middleware('LoginCheck')->middleware('PreventBack');

//Assignment route
Route::get('/AssignmentIndex', [AssignmentController::class, 'AssignmentIndex'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/getAssignmentData', [AssignmentController::class, 'getAssignmentData'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/projectWiseTask', [AssignmentController::class, 'projectWiseTask'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/EmployeeList', [AssignmentController::class, 'EmployeeList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/AssignmentAdd', [AssignmentController::class, 'AssignmentAdd'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/getAssignmentDetails', [AssignmentController::class, 'getAssignmentDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/AssignmentDelete', [AssignmentController::class, 'AssignmentDelete'])->middleware('LoginCheck')->middleware('PreventBack');