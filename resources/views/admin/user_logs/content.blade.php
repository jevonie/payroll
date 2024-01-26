<!--Live Schedule Data-->
<div class="card-header">
    {{-- <div class="col-md-6 d-block">
      <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i> Create Schedule</a>
    </div>
    <div class="col-md-6">
      <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
    </div> --}}
  </div>
  
  <div class="card-body table-responsive p-0">
    <table id="logs_data_table" class="table mb-0 table-hover">
      <thead>
        <tr>
          <th width="3" class="text-center">User</th>
          <th width="45" class="text-center">Log Type</th>
          <th width="45" class="text-center">Log Desc</th>
        </tr>
      </thead>
      <tbody>
        @foreach($logs as $log)
        <tr>
          <td class="text-center">
            {{ $log->name }}
          </td>
          <td>
            <div class="text-center">
              <span><b>{{ $log->log_type }}</b></span>
            </div>
          </td>
          <td class="text-center">
            <span><b>{{ $log->log_desc }}</b></span>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6" class="text-right">
            <h6>Total Logs : <span class="text-danger">{{ $count }}</span> </h6>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!--EndLive Schedule Data-->

  <script type="text/javascript">
    $(document).ready(function(){
      $("#logs_data_table").DataTable();
    });
  </script>
  