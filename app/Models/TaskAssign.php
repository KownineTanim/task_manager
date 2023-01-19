<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
    use HasFactory;

    public function employee(){
        return $this->belongsTo(User::class,'empoyee_id');
    }

    public function taskname(){
        return $this->belongsTo(Task::class,'task_id');
    }

    public function adminname(){
        return $this->belongsTo(User::class,'assigned_by');
    }
}
