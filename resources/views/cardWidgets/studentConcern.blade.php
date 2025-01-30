<div class="card">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('Report Concern') }}</label>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>STATUS</th>
                    <th>DATE REQUEST</th>
                    <th>VICTIM NAME</th>
                    <th>ISSUE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->concernList as $item)
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
                        <td>{{ $item->victim_name }}</td>
                        <td>{{ $item->main_concern }}</td>
                        <td>
                            @if ($item->status === 1)
                                <a class="badge bg-success viewConcernModal" data-bs-toggle="modal"
                                    data-bs-target="#viewConcern" data-value="{{ $item->id }}"
                                    data-route="{{ route('admin.studentConcernStream', ['concern' => ':id']) }}">
                                    VIEW
                                </a>
                                <a class="badge bg-primary">APPROVED</a>
                                <a class="badge bg-danger remove-concern" data-student={{ $item->complainant_id }}
                                    data-concernid={{ $item->id }}>
                                    REMOVE
                                </a>
                            @elseif($item->status === 2)
                                {{--  <span class="badge bg-danger">CANCELLED <i class="bi bi-x-circle text-white"></i></span> --}}
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
<div class="modal fade" id="viewConcern" tabindex="-1" aria-labelledby="viewConcernLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="viewConcernLabel">STUDENT CONCERN</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" class="reportConcern"></iframe>
            </div>
        </div>
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
    $(document).on('click', '.viewConcernModal', function() {
        var id = $(this).data('value');
        var route = $(this).data('route').replace(':id', id); // Replace placeholder with actual ID
        $(".reportConcern").attr("src", route);
    })
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
    $(document).on('click', '.remove-concern', function() {
        var id = $(this).data('id');
        var status_name = $(this).data('name');
        var concern_id = $(this).data('concernid');
        Swal.fire({
            title: 'Concern ',
            text: 'Cancel Request Concern',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0000FF',
            cancelButtonColor: '#ddd',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                $.ajax({
                    url: '{{ route('admin.student.concern.status') }}',
                    type: 'POST',
                    data: {
                        id: 2,
                        concern_id: concern_id,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            // table.ajax.reload();
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error :
                            'There was an error processing your request.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            }
        });
    });
</script>
