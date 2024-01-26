<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employee,Schedule,Position,User,Attendance};

class ReportsController extends Controller
{
    
    private $folder = "admin.reports.";

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
        $employees = Employee::get();
        return View($this->folder.'content',[
            'employees'=>$employees,
            'count' => Employee::count()
        ]);
    }
    public function show($id)
    {
        $employee = Employee::find($id);
        $attendances = Attendance::where("employee_id",$id)->get();
        return View($this->folder.'show',[
            'employee' => $employee,
            'attendances' => $attendances,
        ]);
    }
}
