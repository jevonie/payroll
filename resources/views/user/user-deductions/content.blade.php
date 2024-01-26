<!--Live Deduction Data-->
<div class="card-header">
    <div class="col-md-6 d-block">
      <span>BASIC SALARY: <b>{{ $employee->salary }}</b> PER MONTH</span>
      <div>
        <span>POSITION: <b>{{ $employee->position ? $employee->position->title : "" }}</b></span>
      </div>
    </div>
    {{-- <div class="col-md-6">
      <button type="submit" class="btn btn-primary mb-2 h-33 float-right move-to-delete-all" id="apply" disabled="true" data-href="{{ $moveToTrashAllLink }}">Action</button>
    </div> --}}
  </div>
  
  <div class="card-body table-responsive p-0">
    <table id="state_data_table" class="table mb-0 table-hover">
      <thead>
        <tr>
          <th width="2" class="text-center">No.</th>
          <th width="35" class="text-center">Name</th>
          <th width="10" class="text-center">Amount</th>
          <th width="45">Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach($deductions as $deduction)
        <tr>
          <td class="text-center">
            {{ ($loop->index + 1) }}
          </td>
          <td>
            <div class="text-center">
              <span><b>{{ $deduction->name }}</b></span>
              <code class="pc">{{ $deduction->slug }}</code>
            </div>
          </td>
          <td class="text-center">
            <span><b>Rs. {{ $deduction->amount }}</b></span>
          </td>
          <td>
            <p>{{ $deduction->description }}</p>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6" class="text-right">
            <h6>Total Deductions : <span class="text-danger">Rs. {{ $sum }}</span> </h6>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!--EndLive Deduction Data-->
  