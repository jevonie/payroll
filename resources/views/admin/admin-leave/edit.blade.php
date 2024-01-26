@extends('admin.layout.app')

@section('title') Create Overtime @endsection

@section('css')

<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    .modal-sm{
      width: auto;
      max-width: 356px !important;
    }
    .select2-container--default {
      display: block;
      width: auto !important;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
     <div class="col-lg-8">
        <div class="page-header-title">
           <i class="ik ik-watch bg-blue"></i>
           <div class="d-inline">
              <h5>Leave</h5>
              <span>Create Leave, Please fill all field correctly.</span>
          </div>
      </div>
  </div>
  <div class="col-lg-4">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{{ route('admin.dashboard') }}"><i class="ik ik-home"></i></a>
         </li>
         <li class="breadcrumb-item">
             <a href="{{ route('admin.overtime.index') }}">Leave</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">Create</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">

        <div class="widget overflow-visible">
            <div class="progress progress-sm progress-hi-3 hidden">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="widget-body">
                <div class="overlay hidden">
                    <i class="ik ik-refresh-ccw loading"></i>
                    <span class="overlay-text">New Overtime Creating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h5 class="text-secondary">Create Leave</h5>
                    </div>
                </div>

                <form action="{{ $form_update }}" method="POST" enctype="multipart/form-data" id="createOvertime">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-12 col-lg-12 col-sm-12">
                       <div class="form-group">
                        <label for="employee_id">Employee</label><small class="text-danger">*</small>
                        <select class="form-control" name="employee_id" id="employee_id">
                          @foreach($employees as $employee)
                            <option {{ $employee->id == $leave->employee_id ? "selected" : "" }} value="{{ $employee->id }}">{{ $employee->first_name." ".$employee->last_name." (#".$employee->employee_id.")" }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger err" id="employee_id-err"></small>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-lg-6 col-sm-12">
                       <div class="form-group">
                        <label for="rate_amount">From</label><small class="text-danger">*</small>
                        <input type="text" class="form-control datetimepicker-input" name="from" id="date_from" data-toggle="datetimepicker" data-target="#date_from" autocomplete="off" data-value="{{ $leave->from }}">
                        <small class="text-danger err" id="rate_amount-err"></small>
                      </div>
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12">
                       <div class="form-group">
                        <label for="hour">To</label><small class="text-danger">*</small>
                        <input type="text" class="form-control datetimepicker-input" name="to" id="date_to" data-toggle="datetimepicker" data-target="#date_to" autocomplete="off" data-value="{{ $leave->to }}">
                        <small class="text-danger err" id="hour-err"></small>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                          <label for="description">Status</label>
                          <select class="form-control" name="status" id="status">
                            <option value="PENDING">PENDING</option>
                            <option value="APPROVED">APPROVE</option>
                            <option value="DISAPPROVED">DISAPPROVE</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                          <label for="description">Description</label>  <small class="text-secondary">(Optional)</small>
                          <textarea class="form-control" id="description" name="description" rows="3">{{ $leave->description }}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-lg-12 col-sm-12">
                        <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Update</button>
                        <a href="{{ route('admin.admin-leave.index') }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                      </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function($) {
  $("#employee_id").select2();

  let date_from = $("#date_from").data("value");
  $('#date_from').datetimepicker({
    defaultDate: date_from,
    format: 'LL'
  });

  let date_to = $("#date_to").data("value");
  $('#date_to').datetimepicker({
    defaultDate: date_to,
    format: 'LL'
  });
  $("#createOvertime").submit(function(event){
    event.preventDefault();
    createForm("#createOvertime");
  }); 
});
</script>
@endsection