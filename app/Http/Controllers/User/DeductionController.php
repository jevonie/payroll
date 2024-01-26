<?php

namespace App\Http\Controllers\User;

use App\Models\{Deduction, Employee};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    private $folder = "user.user-deductions.";
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData()
    {
        $deductions = Deduction::get();
        $employee = Employee::find(auth()->user()->employee_id);
        return View($this->folder.'content',[
            'deductions'=>$deductions,
            'sum' => Deduction::sum('amount'),
            'employee' => $employee,
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
