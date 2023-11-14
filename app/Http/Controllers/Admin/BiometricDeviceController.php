<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Helpers\FingerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\FingerDevice\StoreRequest;
use App\Http\Requests\FingerDevice\UpdateRequest;
use App\Jobs\GetAttendanceJob;
use App\Models\FingerDevices;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\DeviceRawLog;
use App\Models\EmployeeBioFp;
// use App\Models\Leave;
use Gate;
use Illuminate\Http\RedirectResponse;
use Rats\Zkteco\Lib\ZKTeco;
use Rats\Zkteco\Lib\Helper\Fingerprint;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class BiometricDeviceController extends Controller
{
    private $folder = "admin.finger_device.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $devices = FingerDevices::all();
        return View($this->folder.'index',[
            'get_data' => route($this->folder.'getData'),
        ]);
       // return view('admin.fingerDevices.index', compact('devices'));
    }

    public function getData(){
        return View($this->folder.'content',[
            'devices' =>  FingerDevices::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->folder.'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $helper = new FingerHelper();

        $device = $helper->init($request->input('ip'));

        if ($device->connect()) {
            // Serial Number Sample CDQ9192960002\x00

            $serial = $helper->getSerial($device);

            FingerDevices::create($request->validated() + ['serialNumber' => $serial]);

            return response()->json([
                'status'=>true,
                'message'=>'Biometric Device created successfully!',
                'redirect_to' => route($this->folder.'index')
            ]);

        } else {

            return response()->json([
                'status' => false,
                'message' => "Something went wrong please try later!"
            ]);
        }

        return redirect()->route('finger_device.index');
    }

    public function show(FingerDevices $fingerDevice)
    {
        return view($this->folder.'show', compact('fingerDevice'));
    }

    public function edit(FingerDevices $fingerDevice)
    {
        return view($this->folder.'edit', compact('fingerDevice'));
    }

    public function update(UpdateRequest $request, FingerDevices $fingerDevice)
    {
        $fingerDevice->update($request->validated());

        return response()->json([
            'status'=>true,
            'message'=>'Biometric Device Updated successfully !',
            'redirect_to' => route($this->folder.'index')
        ]);
    }
    public function destroy(FingerDevices $fingerDevice)
    {
        try {
            $fingerDevice->delete();
        } catch (\Exception $e) {
            toast("Failed to delete {$fingerDevice->name}", 'error');
        }

        return response()->json([
            'status'=>true,
            'message'=>'Biometric Device Deleted successfully !',
            'redirect_to' => route($this->folder.'index')
        ]);
    }

    public function addEmployee(FingerDevices $fingerDevice)
    {
        $device = new ZKTeco($fingerDevice->ip, 4370);

        $device->connect();

        $deviceUsers = collect($device->getUser())->pluck('uid');

        $employees = Employee::select('first_name','last_name', 'id')
            ->whereNotIn('id', $deviceUsers)
            ->get();

        $i = 1;

        foreach ($employees as $employee) {
            $device->setUser($i++, $employee->id, $employee->name, '', '0', '0');
        }

        return response()->json([
            'status'=>true,
            'message'=>'All Employees added to Biometric device successfully!',
            'redirect_to' => route($this->folder.'index')
        ]);
    }

    public function getEmployees(FingerDevices $fingerDevice)
    {   
        $device = new ZKTeco($fingerDevice->ip, 4370);

        $device->connect();

        $employees = Employee::select('id')->get();
        foreach ($employees as $value) {
            
            $fp = Fingerprint::get($device, $value->id);
        
            foreach ($fp as $key => $finger) {
                
               
                $employee = EmployeeBioFp::where("employee_id", $value->id)->where("finger_index", $key)->where("finger_print","<>", null)->first();
                if(!$employee){
                    
                    $newemployee_fp = new EmployeeBioFp();
                    $newemployee_fp->employee_id = $value->id;
                    $newemployee_fp->finger_index = $key;
                    $newemployee_fp->finger_print = base64_encode($finger);
                    $newemployee_fp->save();
                }else{
                    $employee->finger_print = base64_encode($finger);
                    $employee->save();
                }
            }
           
        }

        return response()->json([
            'status'=>true,
            'message'=>'Successfully retrieved data!',
            'redirect_to' => route($this->folder.'index')
        ]);
    }
    
    public function getAttendance(FingerDevices $fingerDevice)
    {   
        $helper = new FingerHelper();

        $device = new ZKTeco($fingerDevice->ip, 4370);

        $device->connect();

        $data = $device->getAttendance();
        
        $serial = $helper->getSerial($device);

        foreach ($data as $key => $value) {
            
            if ($employee = Employee::whereId($value['id'])->first()) {
      
                $existInDb = DeviceRawLog::whereDate("attendance_date", date('Y-m-d', strtotime($value['timestamp'])))
                                    ->where("device_serial_number", $serial)
                                    ->where("employee_id", $value['id'])
                                    ->where("uid",$value['uid'])
                                    ->first();

                if (!$existInDb) {
                    $logs = new DeviceRawLog();
                    $logs->device_serial_number = $serial;
                    $logs->uid                  = $value['uid'];
                    $logs->employee_id          = $value['id'];
                    $logs->state                = $value['state'];
                    $logs->attendance_date      = date('Y-m-d', strtotime($value['timestamp']));
                    $logs->attendance_time      = date('H:i:s', strtotime($value['timestamp']));
                    $logs->status               = 1;
                    $logs->type                 = $value['type'];
                    $logs->save();
                }
               
            }
        }

        $this->processAttendance();

        return response()->json([
            'status'=>true,
            'message'=>'Attendance Queue will run in a minute!',
            'redirect_to' => route($this->folder.'index')
        ]);
    }
    public function processAttendance()
    {   
        $rawLogs = DeviceRawLog::all();
        foreach ($rawLogs as $value) {
            if($value->type==0){
                if ($employee = Employee::whereId($value->employee_id)->first()) {
                    $exist = Attendance::whereDate("date", date('Y-m-d', strtotime($value->attendance_date)))
                            ->where("employee_id", $value->employee_id)
                            ->where("time_in", "<>", null)
                            ->first();

                    if (!$exist) {
                        $attendance = new Attendance();
                        $attendance->uid = $value->uid;
                        $attendance->employee_id = $value->employee_id;
                        $attendance->state = $value->state;
                        
                        $attendance->time_in = $value->attendance_time;
                        if ($employee->schedule->getTimeInRaw() >=  $attendance->getTimeInRaw()) {
                            
                            $attendance->ontime_status = 1;
                        }else{
                            $attendance->ontime_status = 0;
                        }

                        $attendance->date = $value->attendance_date;
                        $attendance->type = $value->type;
                        $attendance->num_hour = 0;
                        
                        
                        $attendance->save();
                    }
                }
            }else{
                if ($employee = Employee::whereId($value->employee_id)->first()) {
                    $attendance = Attendance::whereDate("date", date('Y-m-d', strtotime($value->attendance_date)))
                            ->where("employee_id", $value->employee_id)
                            ->where("time_out", null)
                            ->first();

                    if ($attendance) {
                        $attendance->time_out = $value->attendance_time;
                        if($attendance->time_out != null){
                            if ($employee->schedule->getTimeOutRaw() <= $attendance->getTimeOutRaw()) {
                                $attendance->timeout_status = 1;
                            }else{
                                $attendance->timeout_status = 0;
                            }
                        }
                       
                       

                        $attendance->save();

                        $time_out = new Carbon($attendance->time_out);
                        $time_in = new Carbon($attendance->time_in);

                        $attendance->num_hour = $time_out->diffInMinutes($time_in);
                        $attendance->save();
                    }
                }
               
            }
        }
    }
}
