<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentModel extends Model
{
    public $table='assignments';
    public $primaryKey='id';
    public $incrementing=true;
    public $keyType='int';
    public  $timestamps=false;

    public function project(){
        return $this->belongsTo(ProjectListModel::class,'project_id');
    }

    public function task(){
        return $this->belongsTo(TaskModel::class,'task_id');
    }

    public function employee(){
        return $this->belongsTo(EmployeeModel::class,'employee_id');
    }
}
