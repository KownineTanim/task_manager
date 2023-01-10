<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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
