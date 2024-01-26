<!--data here-->
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">
<!--Live Schedule Data-->
<div class="card-header">
    {{-- <div class="col-md-6 d-block">
      <a href="{{ $add_new }}" class="btn btn-sm btn-dark float-left"><i class="ik plus-square ik-plus-square"></i> Create Schedule</a>
    </div>
    <div class="col-md-6">
      <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
    </div> --}}
    {{-- <div class="col-md-6">
      <div class="input-group mb-0">
        <span class="input-group-prepend">
          <label class="input-group-text"><i class="ik ik-calendar"></i></label>
        </span>
        <input type="text" class="form-control form-control-bold text-center" placeholder="From date - To date" id="date">
        <span class="input-group-append">
          <label class="input-group-text"><i class="ik ik-calendar"></i></label>
        </span>
      </div>
    </div> --}}
    {{-- <div class="col-md-6">
      <button type="submit" class="btn btn-primary mb-2 h-33 float-right" id="pdfBtnPrintpayslilp"><i class="ik ik-printer"></i> REPORTS</button>
    </div> --}}
  </div>
  
  <div class="card-body table-responsive p-0">
    <table id="state_data_table" class="table mb-0 table-hover">
      <thead>
        <tr>
          <th width="3" class="text-center">Employee ID</th>
          <th width="45" class="text-center">Name</th>
          <th width="45" class="text-center">Late</th>
          <th width="45" class="text-center">Early out</th>
          <th width="45" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $employee)
        <tr>
            <td class="text-center">
                {{ $employee->employee_id }}
            </td>
            <td class="text-center">
                {{ $employee->last_name }}, {{ $employee->first_name }}
            </td>
            <td class="text-center">
              {{ $employee->attendances->where('ontime_status', 0)->count() }}
            </td>
            <td class="text-center">
              {{ $employee->attendances->where('timeout_status', 0)->count() }}
            </td>
            <td class="text-center">
                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                  <a data-href="{{route('admin.reports.show',$employee->id)}}" class='show-employee cursure-pointer'>
                    <i class='ik ik-eye text-primary'></i>
                  </a>
                </div>
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
  </div>
</div>
  <!--EndLive Schedule Data-->
  <script type="text/javascript">
  
$(document).ready(function() {

    var crntDate = moment().format('MMMM DD, YYYY');
    var lastDate = moment().subtract(30, 'days').format('MMMM DD, YYYY');
    var datePickerPlug = $('#date').daterangepicker({
      "startDate": lastDate,
      "endDate": crntDate,
      locale: {format: 'MMMM DD, YYYY'},
    });

    var inputDate = $("#date").val();
    $("#payroll_date_input,#payslip_date_input").val(inputDate);

    datePickerPlug.on('apply.daterangepicker', function(ev, picker) {
        var date = picker.startDate.format("MMMM DD, YYYY")+" - "+picker.endDate.format("MMMM DD, YYYY");
        $("#payroll_date_input,#payslip_date_input").val(date);
        table.ajax.reload();
    });
  });
  </script>