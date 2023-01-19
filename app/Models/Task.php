<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function projectname(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function username(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function assign() {
        return $this->hasMany(TaskAssign::class);
    }
}
