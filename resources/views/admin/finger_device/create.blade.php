@extends('admin.layout.app')

@section('title') New Device @endsection

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
                <h5>New Device</h5>
                <span>New Device, Please fill all field correctly.</span>
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
            Create Fingerprint Device
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route("admin.finger_device.store") }}" id="createBiometric">

                @csrf

                <div class="form-group">

                    <label class="required" for="title">Name</label>

                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"

                           name="name"

                           id="title" value="{{ old('name', '') }}" required>

                    @if($errors->has('name'))

                        <span class="text-danger">{{ $errors->first('name') }}</span>

                    @endif

                    <span class="help-block"></span>

                </div>

                <div class="form-group">

                    <label class="required" for="ip">IP Address</label>

                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"

                           name="ip"

                           id="ip" value="{{ old('ip', '') }}" required>

                    @if($errors->has('ip'))

                        <span class="text-danger">{{ $errors->first('ip') }}</span>

                    @endif

                    <span class="help-block"></span>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Submit</button>
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
  $("#createBiometric").submit(function(event){
    event.preventDefault();
    createForm("#createBiometric");
  }); 
});
</script>
@endsection

