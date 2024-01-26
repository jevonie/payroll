<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\UserLog;
use Auth;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function saveLog($log_desc)
    {
        $log = new UserLog();
        $log->user_id   = Auth::user()->id;
        $log->name      = Auth::user()->username ? Auth::user()->username : Auth::user()->name;
        $log->log_type  = "USER LOG";
        $log->log_desc  = $log_desc;
        $log->save();
    }
}
