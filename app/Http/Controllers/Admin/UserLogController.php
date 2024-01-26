<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLogController extends Controller
{
    private $folder = "admin.user_logs.";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_data = route($this->folder.'getData');
        return View($this->folder.'index',[
            'get_data' => $get_data,
        ]);
    }

    public function getData()
    {
        $logs = UserLog::get();
        return View($this->folder.'content',[
            'logs'=>$logs,
            'add_new' => route($this->folder.'create'),
            'count' => UserLog::count(),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserLog $userLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLog $userLog)
    {
        //
    }
}
