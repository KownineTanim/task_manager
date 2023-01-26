<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;
  
    protected $hidden = [
        'password'
    ];

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    // public function projects() {
    //     return $this->hasMany(Project::class);
    // }

    // public function tasks() {
    //     return $this->hasMany(Task::class);
    // }

    // public function assignments() {
    //     return $this->hasMany(TaskAssign::class);
    // }

    // public function admin() {
    //     return $this->hasMany(TaskAssign::class);
    // }

    public function getNameRoleAttribute() {
        return "Name:".$this->name." /Email:".$this->email;
    }
}
