<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('home');
});

//Project route
Route::get('/ProjectIndex', [ProjectController::class, 'ProjectIndex']);
Route::get('/getProjectData', [ProjectController::class, 'getProjectData']);
Route::post('/ProjectAdd', [ProjectController::class, 'ProjectAdd']);
Route::post('/getProjectDetails', [ProjectController::class, 'getProjectDetails']);
Route::post('/ProjectUpdate', [ProjectController::class, 'ProjectUpdate']);
Route::post('/ProjectDelete', [ProjectController::class, 'ProjectDelete']);

//Task route
Route::get('/TaskIndex', [TaskController::class, 'TaskIndex']);
Route::get('/getTaskData', [TaskController::class, 'getTaskData']);
Route::get('/ProjectList', [TaskController::class, 'ProjectList']);
Route::post('/TaskAdd', [TaskController::class, 'TaskAdd']);
Route::post('/getTaskDetails', [TaskController::class, 'getTaskDetails']);
Route::post('/TaskUpdate', [TaskController::class, 'TaskUpdate']);
Route::post('/TaskDelete', [TaskController::class, 'TaskDelete']);

//Employee route
Route::get('/EmployeeIndex', [EmployeeController::class, 'EmployeeIndex']);
Route::get('/getEmployeeData', [EmployeeController::class, 'getEmployeeData']);
Route::post('/EmployeeAdd', [EmployeeController::class, 'EmployeeAdd']);
Route::post('/getEmployeeDetails', [EmployeeController::class, 'getEmployeeDetails']);
Route::post('/EmployeeUpdate', [EmployeeController::class, 'EmployeeUpdate']);
Route::post('/EmployeeDelete', [EmployeeController::class, 'EmployeeDelete']);