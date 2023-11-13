<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Leave, Employee};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{   
    private $folder = "admin.leave.";
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
            'add_new' => route($this->folder.'create'),
            'getDataTable' => route($this->folder.'getDataTable'),
            'moveToTrashAllLink' => route($this->folder.'massDelete'),
            'leaves' => Leave::get(),
        ]);
    }
    public function getDataTable(){

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::get();
        return View($this->folder."create",[
            'form_store' => route($this->folder.'store'),
            'employees' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'employee_id' => $request->employee_id,
            'from' => $request->from,
            'to' => $request->to,
            'description' => $request->description,
        ];
        $overtime = Leave::create($data);

        return response()->json([
            'status'=>true,
            'message'=>'New Leave added successfully.',
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        $employees = Employee::get();
        return View($this->folder.'edit',[
            'leave' => $leave,
            'form_update' => route($this->folder.'update',$leave->id),
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $data = [
            'employee_id' => $request->employee_id,
            'from' => $request->from,
            'to' => $request->to,
            'description' => $request->description,
        ];
        $leave->update($data);

        return response()->json([
            'status'=>true,
            'message'=> "{$leave->employee->first_name} {$leave->employee->last_name} updated successfully.",
            'redirect_to' => route($this->folder.'index')
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        $trash = $leave->delete();
        if($trash){
            return response()->json([
                'status' => true,
                'message' => "Your Record has been Permanent Delete!",
                'getDataUrl' => route($this->folder.'getData'),
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Something went wrong please try later!",
            'getDataUrl' => route($this->folder.'getData'),
        ]);
    }
}
