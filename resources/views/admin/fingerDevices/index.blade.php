@extends('admin.layout.app')

@section('title') Biometric Device @endsection

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
            <i class="fas fa-fingerprint bg-blue"></i>
             <div class="d-inline">
                <h5>Biometric Device</h5>
                <span>You can show and manage Biometric Device from here.</span>
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
               <a href="{{ route('admin.deduction.index') }}">Biometric Device</a>
           </li>
           <li class="breadcrumb-item active" aria-current="page">List of Biometric Device</li>
       </ol>
   </nav>
  </div>
  </div>
  </div>


        <div style="margin-bottom: 10px;" class="row">

            <div class="col-lg-12">

                <a class="btn btn-success" href="{{ route('admin.finger_device.create') }}">Add Fingerprint Device</a>

                {{-- <a class="btn btn-primary"

                   href="{{ route('finger_device.get.attendance') }}">

                    <i class="fas fa-cogs"></i>

                    Run Attendance Queue

                </a> --}}

                <a class="btn btn-primary"

                   href="{{ route('admin.finger_device.clear.attendance') }}">

                    <i class="fas fa-cog"></i>

                    Clear device attendance

                </a>

            </div>

        </div>


    <div class="card">

        <div class="card-header">

            Connected Devices

        </div>



        <div class="card-body">

            <div class="table-rep-plugin">
                <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            
                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>IP Address</th>
                        <th>Serial Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                    </thead>
                    @php
                        $helper = new \App\Helpers\FingerHelper();
                    @endphp
                    <tbody>
                    @foreach($devices as $key => $finger_device)
                        <tr data-entry-id="{{ $finger_device->id }}">

                          

                            <td>

                                {{ $finger_device->id ?? '' }}

                            </td>

                            <td>

                                {{ $finger_device->name ?? '' }}

                            </td>

                            <td>

                                {{ $finger_device->ip ?? '' }}

                            </td>

                            <td>

                                {{ $finger_device->serialNumber ?? '' }}

                            </td>

                            <td>

                                @php

                                    $device = $helper->init($finger_device->ip);

                                @endphp

                                @if($helper->getStatus($device))

                                    <div class="badge badge-success">

                                        Connected

                                    </div>

                                @else

                                    <div class="badge badge-danger">

                                        Disconnected

                                    </div>

                                @endif

                                

                                    <a class="btn btn-xs btn-outline-success bio-actions"
                                       href="{{ route('admin.finger_device.add.employee', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Add Employee
                                    </a>
                                    
                                    <a class="btn btn-xs btn-outline-success bio-actions"
                                       href="{{ route('admin.finger_device.get.attendance', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Get Attendance
                                    </a>

                                    <a class="btn btn-xs btn-outline-success" href="{{ route('admin.finger_device.get.employee', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Get Employee
                                    </a>

                            </td>

                            <td>

                            
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.finger_device.show', $finger_device->id) }}">
                                        View
                                    </a>
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.finger_device.edit', $finger_device->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.finger_device.destroy', $finger_device->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="Delete">
                                    </form>




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
<script>

$(document).ready(function($) {
    $(document).on("click",".bio-actions", function(e){
        e.preventDefault();
        var form_url = $(this).attr("href");
        formGet("get-attendance",1,form_url);
    });
});
</script>
@endsection

