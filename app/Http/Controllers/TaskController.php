<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    function TaskIndex(){
        return view('task');	
}
}
