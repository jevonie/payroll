<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Employee,Overtime,Deduction,Attendance,EmployeeDeduction};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use PDF;

class PayrollController extends Controller
{
    private $folder = "admin.payroll.";

    public function index()
    {
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
    }

    public function getData(){
        return View($this->folder.'content',[
            'add_new' => "/",
            'getDataTable' => route($this->folder.'getDataTable'),
            'payroll_url' => route($this->folder."payrollExportPDF"),
            'payslip_url' => route($this->folder."payslipExportPDF"),
        ]);
    }

    public function getDataTable(Request $request){
    	$payroll = $this->payroll($request);

        return Datatables::of($payroll)
                    ->addIndexColumn()
                    ->addColumn('employee', function($data){
                    	return "<div class='row'><div class='col-md-3 text-center'><img src='".$data->media_url['thumb']."' class='rounded-circle table-user-thumb'></div><div class='col-md-6 col-lg-6 my-auto'><b class='mb-0'>".$data->first_name." ".$data->last_name."</b><p class='mb-2' title='".$data->employee_id."'><small><i class='ik ik-at-sign'></i>".$data->employee_id."</small></p></div><div class='col-md-4 col-lg-4'><small class='text-muted float-right'></small></div></div>";
                    })
                    ->addColumn('gross', function($data){
                        return number_format($data->gross_amount,2);
                    })
                    ->addColumn('deduction', function($data){
                    	return number_format($data->totalDeductions(),2);
                    })
                    ->addColumn('cash_advance', function($data){
                    	return number_format($data->cashAdvances->sum('rate_amount'),2);
                    })
                    ->addColumn('overtime', function($data){
                        $amount = 0;
                        foreach($data->overtimes as $ov){
                            $amount += ($ov->rate_amount * $ov->hour)/60;
                        } 
                        return number_format($amount,2);
                    })
                    ->addColumn('net_pay', function($data){
                        $total_overtime_amount = 0;
                        foreach($data->overtimes as $ov){
                            $total_overtime_amount += ($ov->rate_amount * $ov->hour)/60;
                        }
                    	$total_deduction = $data->totalDeductions() + $data->cashAdvances->sum('rate_amount');

                    	$amount = ($data->gross_amount + $total_overtime_amount) - $total_deduction;
                    	if($amount <= 0){
                    		return "<b class='text-danger'>PHP".number_format($amount,2)."</b>";
                    	}
                    	return "<b>PHP ".number_format($amount,2)."</b>";
                    })
                    ->addColumn('action', function($data){
                        $btn = "<div class='table-actions'>
                        <a href='".route($this->folder."edit",$data->id)."'><i class='ik ik-edit-2 text-dark'></i></a>
                        </div>";
                        return $btn;
                    })
                    ->rawColumns(['employee','gross','deduction','cash_advance','net_pay','overtime','action'])
                    ->toJson();
    }

    public function payrollExportPDF(Request $request){
    	$payrolls = $this->payroll($request);

    	$pdf = PDF::loadView($this->folder."export.payroll",[
    		'payrolls'=> $payrolls,
    		'date'=> $request->date,
    		'deduction_amount' => Deduction::sum("amount")
    	]);
    	
    	/*
    	return View($this->folder."export.payroll",[
    		'payrolls'=> $payrolls,
    		'date'=> $request->date,
    		'deduction_amount' => Deduction::sum("amount")
    	]);
    	*/
    	$fileName = "payroll-".date("d-M-Y")."-".time().'.pdf';
        $this->saveLog("EXPORT PDF: ".$fileName);
    	return $pdf->download($fileName);
    }

    public function payslipExportPDF(Request $request){
    	$payslips = $this->payroll($request);
    	$pdf = PDF::loadView($this->folder."export.payslip",[
    		'payrolls'=> $payslips,
    		'date'=> $request->date,
    		'deduction_amount'=> Deduction::sum("amount"),
            'deductions' => Deduction::get(),
    	]);
		/*
    	return View($this->folder."export.payslip",[
    		'payrolls'=> $payrolls,
    		'date'=> $request->date,
    		'deduction_amount'=> Deduction::sum("amount"),
    	]);
		*/
    	$fileName = "payslip-".date("d-M-Y")."-".time().'.pdf';
        $this->saveLog("EXPORT PAYSLIP: ".$fileName);
        // return $pdf->stream($fileName);
    	return $pdf->download($fileName);
    }
    public function pay13monthExportPDF(Request $request){
        $request->date = "January 01, 2023 - December 31, 2023";
    	$payslips = $this->payroll($request);

    	$pdf = PDF::loadView($this->folder."export.pay13month",[
    		'payrolls'=> $payslips,
    		'date'=> $request->date,
    		'deduction_amount'=> Deduction::sum("amount"),
            'deductions' => Deduction::get(),
    	]);

    	$fileName = "pay13th-".date("d-M-Y")."-".time().'.pdf';
        $this->saveLog("EXPORT PAYSLIP: ".$fileName);
    	return $pdf->stream($fileName);
    }
    private function payroll($request){
        $date = explode(' - ', $request->date);
        
        $start_date = date("Y-m-d",strtotime($date[0]));
        $end_date = date("Y-m-d",strtotime($date[1]));

        $attendances = Attendance::whereBetween("date",[$start_date,$end_date])->pluck('employee_id')->toArray();
        $empIds = array_unique($attendances);

        $payslips = Employee::with([
            "cashAdvances" => function($q) use ($start_date,$end_date){
                $q->whereBetween("date",[$start_date,$end_date]);
            },
            "attendances" => function($q) use ($start_date,$end_date){
                $q->whereBetween("date",[$start_date,$end_date]);
            },
            "overtimes" => function($q) use ($start_date,$end_date){
                $q->whereBetween("date",[$start_date,$end_date]);
            },
            "deductions" => function($q) use ($start_date,$end_date){
                $q->whereBetween("date",[$start_date,$end_date]);
            },
        ])->whereIn("id",$empIds)->get();
        return $payslips;
    }
    public function edit($employee_id)
    {   
        $employee_deductions = EmployeeDeduction::where("employee_id", $employee_id)->get();
        return View($this->folder.'edit',[
            'deductions' =>  Deduction::get(),
            'employee_id' => $employee_id,
            'employee_deductions' => $employee_deductions,
            'store_data' => route($this->folder."update"),
        ]);
    }
    public function update(Request $request)
    { 
        $employee_deduct = new EmployeeDeduction();
        $employee_deduct->date          = $request->month_of.-'01';
        $employee_deduct->employee_id   = $request->employee_id;
        $employee_deduct->deduction_id  = $request->deduction_id;
        $employee_deduct->save();

        return response()->json([
            'status'=>true,
            'message'=> 'Updated successfully.',
            'redirect_to' => route($this->folder.'edit', $request->employee_id)
        ]);
    }
    public function destroy($id)
    { 
        $deduction = EmployeeDeduction::find($id);
        $deduction->delete();
        return response()->json([
                'status' => true,
                'message' => "Your Record has been Deleted!",
                'getDataUrl' => route($this->folder.'edit', $deduction->employee_id),
            ]);
    }
}
