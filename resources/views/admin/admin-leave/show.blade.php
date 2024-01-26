<div class="modal fade show-employee-modal edit-layout-modal pr-0" id="showModel" tabindex="-1" role="dialog" aria-labelledby="showModelLable" aria-hidden="true" data-show="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showModelLable"><i class="ik ik-at-sign"></i>{{ $leave->employee_id }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
  
          <div class="card">
  
            <div class="tab-content">
              <div class="tab-pane fade show active" id="overview">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                      <div class="col-md-6 col-lg-6 my-auto">
                        <h5 class="mb-0">{{ $leave->employee->first_name.' '.$leave->employee->last_name }}</h5>
                        <p class="mb-2" title="employee_id"><small><i class="ik ik-at-sign"></i>{{ $leave->employee_id }}</small></p>
                      </div>
                      <div class="col-md-4 col-lg-4">
                        <small class="text-muted float-right">{{ $leave->created }}</small>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                      <div class="col-md-3 text-right">
                        <b>FROM : </b>
                      </div>
                      <div class="col-md-9">
                        <span>{{ $leave->from }}</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                      <div class="col-md-3 text-right">
                        <b>TO : </b>
                      </div>
                      <div class="col-md-9">
                        <span>{{ $leave->to }}</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                      <div class="col-md-3 text-right">
                        <b>STATUS : </b>
                      </div>
                      <div class="col-md-9">
                        <span>{{ $leave->status }}</span>
                      </div>
                    </div>
                  </a>
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="row">
                    <div class="col-md-3 text-right">
                      <b>DESCRIPTION : </b>
                    </div>
                    <div class="col-md-9">
                      <span>{{ $leave->description }}</span>
                    </div>
                  </div>
                </a>
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