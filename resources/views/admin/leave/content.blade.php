<!--data here-->
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">
  
      <!--Live Banner Data-->
      <div class="card-header">
        <div class="col-md-6 d-block">
          <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i> Create New Leave</a>
        </div>
        <div class="col-md-6">
          <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
        </div>
      </div>
  
      <div class="card-body table-responsive">
          <table id="employee_data_table" class="table table-striped">
            <thead>
              <tr>
                <th>Employee Details</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Actions</th>
                <th>
                
                  {{-- <div class="custom-control custom-checkbox pl-1 align-self-center">
                    <label class="custom-control custom-checkbox mb-0" title="Select All" data-toggle="tooltip" data-placement="right">
                      <input type="checkbox" class="custom-control-input" id="dt-live-select-all">
                      <span class="custom-control-label"></span>
                    </label>
                  </div> --}}
                
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($leaves as $k => $leave)
              <tr>
               <td>
                @php
                    $mediaItems = $leave->employee->getMediaUrlAttribute()['original']; 
                @endphp
                <div class='row'>
                  <div class='col-md-3 text-center'>
                    <img src="{{$leave->employee->mediaUrl['thumb']}}" item="{{$mediaItems}}" class='table-user-thumb'>
                  </div>
                  <div class='col-md-6 col-lg-6 my-auto'>
                    <b class='mb-0'>{{ $leave->employee->first_name }} {{$leave->employee->last_name}}</b>
                    <p class='mb-2' title='".$data->employee->employee_id."'><small><i class='ik ik-at-sign'></i>{{$leave->employee->employee_id}}</small></p>
                  </div>
                  <div class='col-md-4 col-lg-4'>
                    <small class='text-muted float-right'></small>
                  </div>
                </div>
               </td>
               <td>{{ $leave->from }}</td>
               <td>{{ $leave->to }}</td>
               <td>
                @if($leave->is_active == '1')
                  <span class='success-dot' title='Published' title='Active Employee'></span>
                @else
                  <i class='ik ik-alert-circle text-danger alert-status' title='In-Active Employee'></i>
                @endif
               </td>
               <td>
                 <div class='table-actions'>
                  {{-- <a data-href="{{route('admin.leave.show',$leave->employee_id)}}" class='show-employee cursure-pointer'>
                    <i class='ik ik-eye text-primary'></i>
                  </a> --}}
                  <a href="{{route("admin.leave.edit",$leave)}}">
                    <i class='ik ik-edit-2 text-dark'></i>
                  </a>
                  <a data-href="{{route("admin.leave.destroy",$leave)}}" class='delete cursure-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                </div>
               </td>
               <td>
                 <div class="custom-control custom-checkbox pl-1 align-self-center">
                    <label class="custom-control custom-checkbox mb-0">
                      <input type="checkbox" class="custom-control-input sub_chk" data-id="{{$leave->id}}">
                      <span class="custom-control-label"></span>
                    </label>
                  </div>
               </td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      <!--End Live Banner Data-->
  
    </div>
  </div>
  <!--End data here-->
  
  <script type="text/javascript">
    $(document).ready(function(){
      $("#employee_data_table").DataTable();
    });
  </script>