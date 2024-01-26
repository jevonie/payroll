@extends('admin.layout.app')

@section('title') Payroll - Edit Deduction @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
       <div class="col-lg-8">
          <div class="page-header-title">
             <i class="ik ik-file-minus bg-blue"></i>
             <div class="d-inline">
                <h5>Payroll Employee Deduction</h5>
                <span>Edit Deduction, Please fill all field correctly.</span>
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
                <a href="{{ route('admin.payroll.index') }}">Payroll</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Edit</a>
            </li>
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
                    <span class="overlay-text">New Deduction Creating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="Deduction">
                        <h5 class="text-secondary">Add Payroll Deduction</h5>
                    </div>
                </div>

                <form action="{{ $store_data }}" method="POST" id="updatePayroll">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{$employee_id}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <div class="form-group">
                                <label for="date">Date</label><small class="text-danger">*</small>
                                <input type="text" class="form-control datetimepicker-input" name="month_of" id="month_of" data-toggle="datetimepicker" data-target="#month_of" autocomplete="off">
                                <small class="text-danger err" id="date-err"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label for="name">Deductions</label><small class="text-danger">*</small>
                                    <select class="form-control" id="gender" name="deduction_id">
                                        <option selected value disabled>choose</option>
                                        @foreach ($deductions as $item)
                                            <option value="{{$item->id}}">(₱{{ $item->amount}}) {{ $item->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger err" id="name-err"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Submit</button>
                    
                    <a href="{{ route('admin.payroll.index') }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="deduction_data_table" class="table table-striped">
                <thead>
                    <tr>
                    <th>Date</th>
                    <th>Deduction</th>
                    <th>Amount</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee_deductions as $item)
                    <tr>
                        <td>{{$item->date}}</td>
                        <td>{{$item->deduction->name}}</td>
                        <td>{{$item->deduction->amount}}</td>
                        <td>
                            <a data-href="{{ route('admin.payroll.destroy',$item->id) }}" type="button" class="btn btn-sm btn-outline-danger delete">
                                <i class="ik trash-2 ik-trash-2"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function($) {
    $('#month_of').datetimepicker({
        format: 'YYYY-MM'
    });
    $("#deduction_data_table").DataTable();
    $("#updatePayroll").submit(function(event){
        event.preventDefault();
        createForm("#updatePayroll");
    }); 
});
</script>
@endsection