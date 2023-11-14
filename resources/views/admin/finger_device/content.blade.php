<!--data here-->
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade active show" id="live" role="tabpanel" aria-labelledby="pills-timeline-tab">
        <div class="card">

            <div class="card-header">
                <h5>Connected Devices</h5>
            </div>
            <div class="card-body table-responsive">
                <table id="devices_data_table" class="table table-striped">                  
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>IP Address</th>
                            <th>Serial Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    @php
                        $helper = new \App\Helpers\FingerHelper();
                    @endphp
                    <tbody>
                    @foreach($devices as $key => $finger_device)
                        <tr data-entry-id="{{ $finger_device->id }}">          
                            <td>{{ $finger_device->id ?? '' }}</td>
                            <td>{{ $finger_device->name ?? '' }}</td>
                            <td>{{ $finger_device->ip ?? '' }}</td>
                            <td>{{ $finger_device->serialNumber ?? '' }}</td>
                            <td>
                                @php
                                    $device = $helper->init($finger_device->ip);
                                @endphp
                                @if($helper->getStatus($device))
                                    <div class="badge badge-success">
                                        Connected
                                    </div>
                                @else
                                    <div class="badge badge-danger">
                                        Disconnected
                                    </div>
                                @endif
                                    <a class="btn btn-xs btn-outline-success bio-actions"
                                    href="{{ route('admin.finger_device.add.employee', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Add Employee
                                    </a>
                                    <a class="btn btn-xs btn-outline-success bio-actions"
                                    href="{{ route('admin.finger_device.get.attendance', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Get Attendance
                                    </a>
                                    <a class="btn btn-xs btn-outline-success" href="{{ route('admin.finger_device.get.employee', $finger_device->id) }}">
                                        <i class="fas fa-plus"></i>
                                        Get Employee
                                    </a>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary"
                                href="{{ route('admin.finger_device.show', $finger_device->id) }}">
                                    View
                                </a>
                                <a class="btn btn-xs btn-info"
                                href="{{ route('admin.finger_device.edit', $finger_device->id) }}">
                                    Edit
                                </a>
                                <form action="{{ route('admin.finger_device.destroy', $finger_device->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                        value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $("#devices_data_table").DataTable();
    });
</script>