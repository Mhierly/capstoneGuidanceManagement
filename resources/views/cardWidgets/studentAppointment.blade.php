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
                                <button class="btn btn-primary btn-sm btn-appointment" data-bs-toggle="modal"
                                    data-bs-target="#complete_appointment" data-value="{{ $item->appointment_id }}">
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
<script>
    $(document).on('click', '.btn-appointment', function() {
        var id = $(this).data('value');
        console.log(id);
        $('#appointmentInput').val(id); // Correct way to set value

        /* $.ajax({
            url: '{{ route('admin.student.appointment.status') }}',
            type: 'POST',
            data: {
                appointment_id: appointment_id,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON
                    .error ? xhr.responseJSON.error :
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
        }); */
    })
</script>
