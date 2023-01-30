<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginContoller;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;


//Employee Login route
Route::middleware(['guest'])->group(function(){
    Route::get('/', [UserLoginContoller::class, 'LoginIndex'])->name('login');
    Route::post('/user/onLogin', [UserLoginContoller::class, 'onLoginUser']);
    Route::get('/admin', [LoginController::class, 'LoginIndex']);
    Route::post('/admin/onLogin', [LoginController::class, 'onLogin']);
});
Route::middleware(['auth', 'PreventBack'])->group(function() {
    
    Route::get('/user/onLogout', [UserLoginContoller::class, 'onLogout'])->name('logout');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index']);
    Route::get('/user/task-assigned', [UserDashboardController::class, 'assignmentIndex'])->name('task.assigned');;
    Route::post('/user/task-start', [UserDashboardController::class, 'assignmentStart'])->name('task.start');;

    //Admin Login route
    Route::get('/admin/onLogout', [LoginController::class, 'onLogout']);

    //Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

    //Project route
    Route::get('/project', [ProjectController::class, 'index']);
    Route::post('/project/add', [ProjectController::class, 'store']);
    Route::post('/project/getDetails', [ProjectController::class, 'getDetails']);
    Route::post('/project/update', [ProjectController::class, 'update']);
    Route::post('/project/delete', [ProjectController::class, 'delete']);

    //Task route
    Route::get('/task', [TaskController::class, 'index']);
    Route::get('/project-list', [TaskController::class, 'ProjectList']);
    Route::post('/task/add', [TaskController::class, 'store']);
    Route::post('/task/getDetails', [TaskController::class, 'getDetails']);
    Route::post('/task/update', [TaskController::class, 'update']);
    Route::post('/task/delete', [TaskController::class, 'delete']);

    //User role route
    Route::get('/user_role', [RoleController::class, 'index']);
    Route::post('/role/add', [RoleController::class, 'store']);
    Route::post('/role/getDetails', [RoleController::class, 'getDetails']);
    Route::post('/role/update', [RoleController::class, 'update']);
    Route::post('/role/delete', [RoleController::class, 'delete']);

    //User route
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/role-list', [UserController::class, 'RoleList']);
    Route::post('/user/add', [UserController::class, 'store']);
    Route::post('/user/getDetails', [UserController::class, 'getDetails']);
    Route::post('/user/delete', [UserController::class, 'delete']);

    //Assignment route
    Route::get('/assignment', [AssignmentController::class, 'index']);
    Route::get('/employee-list', [AssignmentController::class, 'EmployeeList']);
    Route::get('/task-list', [AssignmentController::class, 'TaskList']);
    Route::post('/assignment/add', [AssignmentController::class, 'store']);
    Route::post('/assignment/getDetails', [AssignmentController::class, 'getDetails']);
    Route::post('/assignment/update', [AssignmentController::class, 'update']);
    Route::post('/assignment/delete', [AssignmentController::class, 'delete']);
});