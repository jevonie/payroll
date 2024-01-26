<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'from',
        'to',
        'type',
        'description',
        'status',
        'is_active',
        'employee_notif',
        'admin_notif',
        'finance_notif',
    ];

    
    protected $dates = [
        'created_at',
        'updated_at',
        'from',
        'to',
    ];

    public function getFromAttribute(){
        return date("M d, Y",strtotime($this->attributes['from']));
    }

    public function setFromAttribute($value){
        $this->attributes['from'] = date("Y-m-d",strtotime($value));
    }
    public function getToAttribute(){
        return date("M d, Y",strtotime($this->attributes['to']));
    }

    public function setToAttribute($value){
        $this->attributes['to'] = date("Y-m-d",strtotime($value));
    }
    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
