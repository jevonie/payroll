@extends('admin.layout.app')

@section('title') Edit Device @endsection

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
                <span>Edit Device, Please fill all field correctly.</span>
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

        <div class="card-header">Edit Fingerprint Device</div>

        <div class="card-body">

            <form method="POST" action="{{ route("admin.finger_device.update", $fingerDevice->id) }}" id="updateBiometric">

                @csrf

                @method('PUT')

                <div class="form-group">

                    <label class="required" for="title">Name</label>

                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"

                           name="name"

                           id="title" value="{{ old('name', $fingerDevice->name) }}" required>

                    @if($errors->has('name'))

                        <span class="text-danger">{{ $errors->first('name') }}</span>

                    @endif

                    <span class="help-block"></span>

                </div>

                <div class="form-group">

                    <label class="required" for="ip">IP Address</label>

                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"

                           name="ip"

                           id="ip" value="{{ old('ip', $fingerDevice->ip) }}" required>

                    @if($errors->has('ip'))

                        <span class="text-danger">{{ $errors->first('ip') }}</span>

                    @endif

                    <span class="help-block"></span>

                </div>

                <div class="form-group">

                    <label class="required"

                           for="serialNumber">Serial Number</label>

                    <input class="form-control {{ $errors->has('serialNumber') ? 'is-invalid' : '' }}" type="text"

                           name="serialNumber"

                           id="serialNumber" value="{{ old('serialNumber', $fingerDevice->serialNumber) }}" required>

                    @if($errors->has('serialNumber'))

                        <span class="text-danger">{{ $errors->first('serialNumber') }}</span>

                    @endif

                    <span class="help-block"></span>

                </div>

                <div class="form-group">

                    <button class="btn btn-primary" type="submit">

                        {{ trans('global.update') }}

                    </button>
                    <a href="{{ route('admin.finger_device.index') }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
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
  $("#updateBiometric").submit(function(event){
    event.preventDefault();
    editForm("#updateBiometric");
  }); 
});
</script>
@endsection

