<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    use HasFactory;

    public function deduction(){
        return $this->hasOne(Deduction::class,'id','deduction_id');
    }
}
