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
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Actions</th>
                <th>
                
                  {{-- <div class="custom-control custom-checkbox pl-1 align-self-center">nba liveliq
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
               <td>{{ $leave->from }}</td>
               <td>{{ $leave->to }}</td>
               <td>
                @if ($leave->status == "PENDING")
                  <span class="badge text-primary ">{{ $leave->status }}</span>
                @elseif ($leave->status == "APPROVED")
                  <span class="badge text-success ">{{ $leave->status }}</span>
                @elseif ($leave->status == "DISAPPROVED")
                  <span class="badge text-danger ">{{ $leave->status }}</span>
                @else
                  {{ $leave->status }}
                @endif
               </td>
               <td>
                @if ($leave->status == "PENDING")
                 <div class='table-actions'>
                    {{-- <a data-href="{{route('admin.leave.show',$leave->employee_id)}}" class='show-employee cursure-pointer'>
                      <i class='ik ik-eye text-primary'></i>
                    </a> --}}
                    <a href="{{route("user.leave.edit",$leave)}}">
                      <i class='ik ik-edit-2 text-dark'></i>
                    </a>
                    <a data-href="{{route("user.leave.destroy",$leave)}}" class='delete cursure-pointer'><i class='ik ik-trash-2 text-danger'></i></a>
                  </div>
                @endif 
               </td>
               <td>
                @if ($leave->status == "PENDING")
                 <div class="custom-control custom-checkbox pl-1 align-self-center">
                    <label class="custom-control custom-checkbox mb-0">
                      <input type="checkbox" class="custom-control-input sub_chk" data-id="{{$leave->id}}">
                      <span class="custom-control-label"></span>
                    </label>
                  </div>
                @endif
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