<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'time_in',
        'time_out',
        'next_day',
    ];

    public $timestamps = false;

    public function getTimeInAttribute(){
    	return date('h:i A', strtotime($this->attributes['time_in']));
    }

    public function getTimeOutAttribute(){
    	return date('h:i A', strtotime($this->attributes['time_out']));
    }

    public function setTimeInAttribute($value){
        $this->attributes['time_in'] = date('H:i:s', strtotime($value));
    }

    public function setTimeOutAttribute($value){
        $this->attributes['time_out'] = date('H:i:s', strtotime($value));
    }
    public function getTimeInRaw(){
        return date('H:i:s', strtotime($this->attributes['time_in']));
    }
    public function getTimeOutRaw(){
        return date('H:i:s', strtotime($this->attributes['time_out']));
    }

}
