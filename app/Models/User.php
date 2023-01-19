<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use HasFactory;
  
    protected $hidden = [
        'password'
    ];

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function assignments() {
        return $this->hasMany(TaskAssign::class);
    }

    public function admin() {
        return $this->hasMany(TaskAssign::class);
    }
}
