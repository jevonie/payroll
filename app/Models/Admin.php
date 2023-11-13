<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	protected $guard = 'admin';
	
    protected $fillable = [
        'email',
        'username',
        'image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
