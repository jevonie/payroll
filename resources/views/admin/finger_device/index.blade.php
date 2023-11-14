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

<div class="row">
    <div class="col-lg-12 col-md-12 mt-4">
        <div class="card">

        <!--Tab content-->
        <div class="loader br-4 hidden">
            <i class="ik ik-refresh-cw loading"></i>
            <span class="loader-text">Data Fetching....</span>
        </div>
        <div class="tabs_contant">
            <div class="card-header">
            <h5>Looking for Connected Devices..</h5>
            </div>
            <div class="card-body">
                
            </div>
        </div>
        <!--End Tab Content-->
        </div>
    </div>
</div>
        
<div class="row">
    <div class="col-md-12">
        <form id="deleteForm" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" name="submit" class="hidden">
        </form>
    </div>
</div>


@endsection

@section('js')
<script>

$(document).ready(function($) {

    // get data from serve ajax
    const getDataUrl = "{{ $get_data }}"
    getData(getDataUrl);

    $(document).on("click",".bio-actions", function(e){
        e.preventDefault();
        var form_url = $(this).attr("href");
        formGet("get-attendance",1,form_url);
    });
});
</script>
@endsection

