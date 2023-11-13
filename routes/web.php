<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* end of application configration routes*/
Route::get('/',[App\Http\Controllers\Admin\DashboardController::class , 'dashboard'])->middleware('RedirectWhenNotLogin')->name('dash');

// checkin routes
Route::controller(App\Http\Controllers\Admin\CheckInController::class)->group(function () {
    Route::get('/checkin',"checkin")->name('admin.checkin.index');
    Route::post('/checkin',"store")->name('admin.checkin.store');
    Route::put('/checkin',"update")->name('admin.checkin.update');
});

Route::group(['as'=>'admin.'],function(){
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login',"showLogin")->name('showLogin');
        Route::post('/login',"login")->name('login');
    });
});

Route::group(['as'=>'admin.'],function(){
	
	Route::group(['middleware'=>'auth'],function(){

	    Route::post("/logout",[App\Http\Controllers\Admin\Auth\AuthController::class, 'logout'])->name('logout');

		// media related routes
        Route::controller(HelperController::class)->group(function () {
            Route::post('/media', 'storeMedia')->name('storeMedia');
            Route::get('/media/showMediaFromTempFolder/{name}', 'showMediaFromTempFolder')->name('showMediaFromTempFolder');
            Route::post('/media/base64EncodedData', 'storeMediaBase64')->name('storeMediaBase64');
            Route::post('/media/removeMediaFromTempFolder/{name}', 'removeMediaFromTempFolder')->name('removeMediaFromTempFolder');
            Route::post('/media/removeMedia/{model}/{model_id}/{collection}', 'removeMedia')->name('removeMedia');
            Route::post('/confirm/password', 'confirmPassword')->name('confirmPassword');
        });

		// Dashboard Routes
		Route::get("/dashboard",[App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
		
		//admin profile route
        Route::controller(App\Http\Controllers\Admin\ProfileController::class)->group(function () {
            Route::get("/profile","index")->name('profile.index');
            Route::post("/profile","update")->name('profile.update');
        });

		//position routes
		Route::resource('position',App\Http\Controllers\Admin\PositionController::class);
        Route::controller(App\Http\Controllers\Admin\PositionController::class)->group(function () {
            Route::post('getdata/position',"getData")->name('position.getData');
            Route::post('all-delete/position/',"massDelete")->name('position.massDelete');
        });

		//deduction routes
		Route::resource('deduction',App\Http\Controllers\Admin\DeductionController::class);
        Route::controller(App\Http\Controllers\Admin\DeductionController::class)->group(function () {
            Route::post('getdata/deduction',"getData")->name('deduction.getData');
            Route::post('all-delete/deduction/',"massDelete")->name('deduction.massDelete');
        });

		//schedule routes
		Route::resource('schedule', App\Http\Controllers\Admin\ScheduleController::class);
        Route::controller(App\Http\Controllers\Admin\ScheduleController::class)->group(function () {
            Route::post('getdata/schedule',"getData")->name('schedule.getData');
            Route::post('all-delete/schedule/',"massDelete")->name('schedule.massDelete');
        });

		//employee routes
		Route::resource('employee',App\Http\Controllers\Admin\EmployeeController::class);
        Route::controller(App\Http\Controllers\Admin\EmployeeController::class)->group(function () {
            Route::post('getdata/employee',"getData")->name('employee.getData');
            Route::post('get-employees-data',"getDataTable")->name('employee.getDataTable');
            Route::post('all-delete/employee/',"massDelete")->name('employee.massDelete');
        });

		//overtime routes
		Route::resource('overtime', App\Http\Controllers\Admin\OvertimeController::class);
        Route::controller(App\Http\Controllers\Admin\OvertimeController::class)->group(function () {
            Route::post('getdata/overtime',"getData")->name('overtime.getData');
            Route::post('get-overtime-data',"getDataTable")->name('overtime.getDataTable');
            Route::post('all-delete/overtime/',"massDelete")->name('overtime.massDelete');
        });
		//cashadvance routes
		Route::resource('cashadvance',App\Http\Controllers\Admin\CashAdvanceController::class);
        Route::controller(App\Http\Controllers\Admin\CashAdvanceController::class)->group(function () {
            Route::post('getdata/cashadvance',"getData")->name('cashadvance.getData');
            Route::post('get-cashadvance-data',"getDataTable")->name('cashadvance.getDataTable');
            Route::post('all-delete/cashadvance/',"massDelete")->name('cashadvance.massDelete');
        });

		//attendance routes
        Route::resource('attendance', App\Http\Controllers\Admin\AttendanceController::class);
        Route::controller(App\Http\Controllers\Admin\AttendanceController::class)->group(function () {
            Route::post('getdata/attendance',"getData")->name('attendance.getData');
            Route::post('get-attendance-data',"getDataTable")->name('attendance.getDataTable');
            Route::post('all-delete/attendance/',"massDelete")->name('attendance.massDelete');
        });

		//payroll routes
        Route::controller(App\Http\Controllers\Admin\PayrollController::class)->group(function () {
            Route::get('payroll',"index")->name('payroll.index');
            Route::post('getdata/payroll',"getData")->name('payroll.getData');
            Route::post('get-payroll-data',"getDataTable")->name('payroll.getDataTable');
            Route::post('payroll/download-payroll',"payrollExportPDF")->name('payroll.payrollExportPDF');
            Route::post('payroll/download-payslip',"payslipExportPDF")->name('payroll.payslipExportPDF');
        });

        //leave routes
        Route::resource('leave',App\Http\Controllers\Admin\LeaveController::class);
        Route::controller(App\Http\Controllers\Admin\LeaveController::class)->group(function () {
            Route::post('getdata/leave',"getData")->name('leave.getData');
            Route::post('get-leave-data',"getDataTable")->name('leave.getDataTable');
            Route::post('all-delete/leave/',"massDelete")->name('leave.massDelete');
        });

        // Fingerprint Devices
        Route::resource('/finger_device', App\Http\Controllers\Admin\BiometricDeviceController::class);
        Route::controller(App\Http\Controllers\Admin\BiometricDeviceController::class)->group(function () {
            Route::delete('finger_device/destroy', 'massDestroy')->name('finger_device.massDestroy');
            Route::get('finger_device/{fingerDevice}/employees/add', 'addEmployee')->name('finger_device.add.employee');
            Route::get('finger_device/{fingerDevice}/get/attendance', 'getAttendance')->name('finger_device.get.attendance');
            Route::get('finger_device/{fingerDevice}/get/employees', 'getEmployees')->name('finger_device.get.employee');
        });

        // Temp Clear Attendance route
        Route::get('finger_device/clear/attendance', function () {
            $midnight = \Carbon\Carbon::createFromTime(23, 50, 00);
            $diff = now()->diffInMinutes($midnight);
            dispatch(new ClearAttendanceJob())->delay(now()->addMinutes($diff));
            toast("Attendance Clearance Queue will run in 11:50 P.M}!", "success");

            return back();
        })->name('finger_device.clear.attendance');

	});
});