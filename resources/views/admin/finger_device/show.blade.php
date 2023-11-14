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
                <span>Biometric Device details.</span>
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
               <a href="{{ route('admin.deduction.index') }}">Deduction</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
        </nav>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">
    <div class="card">

        <div class="card-header">

            Show Fingerprint Devices

        </div>

        <div class="card-body">

            <div class="form-group">

                <div class="form-group">

                    <a class="btn btn-primary" href="{{ route('admin.finger_device.index') }}">

                        Back to list

                    </a>

                </div>

                <table class="table table-bordered table-striped">

                    <tbody>

                    <tr>

                        <th>

                            ID

                        </th>

                        <td>

                            {{ $fingerDevice->id }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Name

                        </th>

                        <td>

                            {{ $fingerDevice->name }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            IP Address

                        </th>

                        <td>

                            {{ $fingerDevice->ip }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Serial Number

                        </th>

                        <td>

                            {{ $fingerDevice->serialNumber }}

                        </td>

                    </tr>

                    </tbody>

                </table>

                

            </div>

        </div>

    </div>
    </div>
</div>
@endsection

