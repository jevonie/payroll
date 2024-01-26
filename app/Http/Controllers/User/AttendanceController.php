<?php

namespace App\Http\Controllers\User;

use App\Models\{Employee,Attendance};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class AttendanceController extends Controller
{
    private $folder = "user.user-attendance.";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData(){
        return View($this->folder.'content',[
            // 'add_new' => route($this->folder.'create'),
            'getDataTable' => route($this->folder.'getDataTable'),
            
        ]);
    }

    public function getDataTable(){
        $attendance = Attendance::where("employee_id", auth()->user()->employee_id)->latest();

        return Datatables::of($attendance)
                    ->addIndexColumn()
                    ->addColumn('time_in_details', function($data){
                        $status = "<div>";
                        $status .= "<span class='float-left'>";
                        $status.= $data->date ? $data->date." @ " : "a";
                        $status.= $data->time_in;
                        $status .= "</span>";
                            $status .= "<span class='float-right badge'>";
                            if(!$data->ontime_status){
                            $status.= "<span class='text-danger'>LATE</span>";
                            }else{
                            $status.= "<span class='text-primary'>ONTIME</span>";
                            }
                            $status .= "</span>";
                            return $status;
                    })
                    ->addColumn('time_out_details', function($data){
                        $status = "<div>";
                        $status .= "<span class='float-left'>";
                        $status.= $data->date_timeout ? $data->date_timeout." @ " : "a";
                        $status.= $data->time_out ? $data->time_out : "a";
                        $status .= "</span>";
                            $status .= "<span class='float-right badge'>";
                            if($data->timeout_status == 0 && $data->timeout_status != ""){
                                $status.= "<span class='text-danger'>EARLY OUT</span>";
                            }else if($data->timeout_status == 1){
                                $status.= "<span class='text-primary'>ONTIME</span>";
                            }else{
                                $status.= "<span class='text-default'>NO DATA</span>";
                            }
                            $status .= "</span>";
                            return $status;
                    })
                    
                    ->addColumn('work_hr', function($data){
                            return $data->num_hour."/hr";
                    })
                    ->rawColumns(['time_in_details','time_out_details','work_hr'])
                    ->toJson();
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
