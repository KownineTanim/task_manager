<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');

//Project route
Route::get('/project', [ProjectController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/project/add', [ProjectController::class, 'store'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/project/getDetails', [ProjectController::class, 'getDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/project/update', [ProjectController::class, 'update'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/project/delete', [ProjectController::class, 'delete'])->middleware('LoginCheck')->middleware('PreventBack');

//Task route
Route::get('/task', [TaskController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/project-list', [TaskController::class, 'ProjectList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/task/add', [TaskController::class, 'store'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/task/getDetails', [TaskController::class, 'getDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/task/update', [TaskController::class, 'update'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/task/delete', [TaskController::class, 'delete'])->middleware('LoginCheck')->middleware('PreventBack');

//User role route
Route::get('/user_role', [RoleController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/role/add', [RoleController::class, 'store'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/role/getDetails', [RoleController::class, 'getDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/role/update', [RoleController::class, 'update'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/role/delete', [RoleController::class, 'delete'])->middleware('LoginCheck')->middleware('PreventBack');

//User route
Route::get('/user', [UserController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/role-list', [UserController::class, 'RoleList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/user/add', [UserController::class, 'store'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/user/getDetails', [UserController::class, 'getDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/user/delete', [UserController::class, 'delete'])->middleware('LoginCheck')->middleware('PreventBack');

//Assignment route
Route::get('/assignment', [AssignmentController::class, 'index'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/employee-list', [AssignmentController::class, 'EmployeeList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::get('/task-list', [AssignmentController::class, 'TaskList'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/assignment/add', [AssignmentController::class, 'store'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/assignment/getDetails', [AssignmentController::class, 'getDetails'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/assignment/update', [AssignmentController::class, 'update'])->middleware('LoginCheck')->middleware('PreventBack');
Route::post('/assignment/delete', [AssignmentController::class, 'delete'])->middleware('LoginCheck')->middleware('PreventBack');
