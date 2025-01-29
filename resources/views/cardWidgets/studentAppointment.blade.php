<div class="card">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('Request Appointment') }}</label>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>STATUS</th>
                    <th>DATE REQUEST</th>
                    <th>SUBJECT</th>
                    <th>REASON</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->listOfAppoitments as $item)
                    <tr>
                        <td>
                            @if ($item->status === 1)
                                <span class="badge bg-secondary">PENDING <i
                                        class="bi bi-hourglass-bottom text-white"></i></span>
                            @elseif($item->status === 2)
                                <span class="badge bg-danger">CANCELLED <i class="bi bi-x-circle text-white"></i></span>
                            @elseif($item->status === 3)
                                <span class="badge bg-success">APPROVED <i
                                        class="bi bi-check-circle text-white"></i></span>
                            @elseif($item->status === 4)
                                <span class="badge bg-primary">COMPLETED <i
                                        class="bi bi-check-circle-fill text-white"></i></span>
                            @else
                                {{ $item->status }}
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('F d,Y') }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>
                            @if ($item->status === 1)
                                <button class="btn btn-primary btn-sm btn-appointment" data-bs-toggle="modal"
                                    data-bs-target="#edit_profile"
                                    data-value="{{ $item->appointment_id }}">VIEW</button>
                            @elseif($item->status === 2)
                                <span class="badge bg-danger">CANCELLED <i class="bi bi-x-circle text-white"></i></span>
                            @elseif($item->status === 3)
                                <button class="btn btn-primary btn-sm btn-appointment-details" data-bs-toggle="modal"
                                    data-bs-target="#appointmentDetails" data-value="{{ $item->appointment_id }}">
                                    COMPLETE
                                    SESSION</button>
                            @elseif($item->status === 4)
                                <button class="btn btn-primary btn-sm btn-appointment" data-bs-toggle="modal"
                                    data-bs-target="#complete_appointment" data-value="{{ $item->appointment_id }}">
                                    VIEW REPORT
                                </button>
                            @else
                                {{ $item->status }}
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="edit_profile" tabindex="-1" aria-labelledby="edit_profileLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="edit_profileLabel">REQUEST APPOINTMENT DETAILS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SUBJECT</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary subject"></label>
                    </div>
                    <div class="col-md-4">
                        <small class="fw-bolder text-muted">REQUEST DATE</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary request-date"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small class="fw-bolder text-muted">REASON</small>
                        <label for="" class="form-control form-control-sm border border-primary reason"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SCHEDULED DATE</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary scheduled-date"></label>
                    </div>
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SCHEDULED TIME</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary scheduled-time"></label>
                    </div>
                </div>
                <form action="{{ route('adminStoreScheduled') }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointmentID" id="appointmentInput">
                    <div class="row">
                        <div class="form-group col-md">
                            <small class="fw-bolder text-muted">APPOINTMENT DATE:</small>
                            <input type="date" class="form-control form-control-sm border border-primary"
                                id="appointmentDate" name="appointmentDate" required>
                            @error('appointmentDate')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md">
                            <small class="fw-bolder text-muted">APPOINTMENT TIME:</small>
                            <input type="time" class="form-control form-control-sm border border-primary"
                                id="appointmentTime" name="appointmentTime" required>
                            @error('appointmentTime')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary float-end mt-3">
                        SUBMIT
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="appointmentDetails" tabindex="-1" aria-labelledby="appointmentDetailsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="appointmentDetailsLabel">APPOINTMENT DETAILS</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SUBJECT</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary subject"></label>
                    </div>
                    <div class="col-md-4">
                        <small class="fw-bolder text-muted">REQUEST DATE</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary request-date"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small class="fw-bolder text-muted">REASON</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary reason"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SCHEDULED DATE</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary scheduled-date"></label>
                    </div>
                    <div class="col-md">
                        <small class="fw-bolder text-muted">SCHEDULED TIME</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary scheduled-time"></label>
                    </div>
                </div>
                <label for="" class="mt-3 text-primary">COMPLETE APPOINTMENT</label>
                <form action="{{ route('adminStoreDuration') }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointmentID" id="appointmentInput" class="appointmentInput">
                    <div class="row">
                        <div class="form-group col-md">
                            <small class="fw-bolder text-muted">START SESSION</small>
                            <input type="time" class="form-control form-control-sm border border-primary"
                                id="appointment_time_from" name="appointment_time_from" required>
                            @error('appointment_time_from')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md">
                            <small class="fw-bolder text-muted">END SESSION</small>
                            <input type="time" class="form-control form-control-sm border border-primary"
                                id="appointment_time_to" name="appointment_time_to" required>
                            @error('appointment_time_to')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary float-end mt-3">
                        SUBMIT
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.btn-appointment', function() {
        var id = $(this).data('value');
        console.log(id);
        $('#appointmentInput').val(id); // Correct way to set value
        $.get('/admin/appointment/details?value=' + id, function(response) {
            console.log(response)
            if (response.appointment) {
                let appointment = response.appointment
                $('.subject').text(appointment.subject)
                $('.request-date').text(convertDate(appointment.created_at))
                $('.reason').text(appointment.subject)
                $('.scheduled-date').text(appointment.appointment_date)
                $('.scheduled-time').text(appointment.appointment_time)

            }
        })
    })
    $(document).on('click', '.btn-appointment-details', function() {
        var id = $(this).data('value');
        $('.appointmentInput').val(id);
        $.get('/admin/appointment/details?value=' + id, function(response) {
            console.log(response)
            if (response.appointment) {
                let appointment = response.appointment
                $('.subject').text(appointment.subject)
                $('.request-date').text(convertDate(appointment.created_at))
                $('.reason').text(appointment.subject)
                $('.scheduled-date').text(appointment.appointment_date)
                $('.scheduled-time').text(appointment.appointment_time)

            }
        })
    })

    function convertDate(date1) {
        const date = new Date(date1);
        const format = date.toISOString().replace('T', ' ').substring(0, 19);
        return format
        console.log(format);
        // Output: "2025-01-24 16:08:11"

    }
</script>
