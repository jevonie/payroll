<div class="modal fade show-employee-modal edit-layout-modal pr-0" id="showModel" tabindex="-1" role="dialog" aria-labelledby="showModelLable" aria-hidden="true" data-show="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showModelLable"><i class="ik ik-at-sign"></i>{{ $employee->employee_id }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
  
          <div class="card">
  
            <div class="tab-content">
              <div class="tab-pane fade show active" id="overview">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                      <div class="col-md-3 text-center">
                        <img src="{{ $employee->getFirstMediaUrl('avatar','thumb') }}" class="rounded-circle show-avatar" alt="{{ $employee->employee_id }}'s Avatar">
                      </div>
                      <div class="col-md-6 col-lg-6 my-auto">
                        <h5 class="mb-0">{{ $employee->first_name.' '.$employee->last_name }}</h5>
                        <p class="mb-2" title="employee_id"><small><i class="ik ik-at-sign"></i>{{ $employee->employee_id }}</small></p>
                      </div>
                      <div class="col-md-4 col-lg-4">
                        <small class="text-muted float-right">{{ $employee->created }}</small>
                      </div>
                    </div>
                  </a>
                  <div class="card-body table-responsive">
                    <table id="overtime_data_table" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>Working Hour</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($attendances as $item)
                            <tr>
                              <td>{{ $item->date }}</td>
                              <td>{{ $item->time_in }}</td>
                              <td>{{ $item->time_out }}</td>
                              <td>{{ $item->num_hour }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
  
                </div>
              </div>
            </div>
          </div>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>