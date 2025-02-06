<div class="card mt-3">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('recent Appointments') }}</label>
        <button type="button" class="btn btn-secondary btn-sm float-end" data-bs-toggle="modal"
            data-bs-target="#modalRequestFormAppointment">
            CREATE REQUEST
        </button>
    </div>
    <div class="card-body table-responsive">
        <div {{-- class="table-responsive" style="overflow-x: auto;" --}}>
            <table class="table table-hover table-bordered table-striped" style="min-width:50%">
                <thead>
                    <tr>
                        <th>STATUS</th>
                        <th style="width: 25%">REQUEST DATE</th>
                        <th style="width: 25%">DATE OF SCHEDULED</th>
                        <th style="width: 25%">SUBJECTS</th>
                        <th style="width: 70%">REASON</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $item)
                        <tr>
                            <td>

                                @if ($item->status === 1)
                                    <span class="badge bg-secondary">PENDING <i
                                            class="bi bi-hourglass-bottom text-white"></i></span>
                                @elseif($item->status === 2)
                                    <span class="badge bg-danger">CANCELLED <i
                                            class="bi bi-x-circle text-white"></i></span>
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
                            <td>{{ $item->created_at->format('F d, Y h:i a') }}</td>
                            <td>
                                @if ($item->status != 1 && $item->status != 2)
                                    @if ($item->appointment_date != null || $item->appointment_time != null)
                                        @php
                                            // Combine the date and time
                                            $appointmentDateTime =
                                                $item->appointment_date . ' ' . $item->appointment_time;

                                            // Create a DateTime instance from the string
                                            $appointment = new DateTime($appointmentDateTime);
                                        @endphp
                                        <span class="badge bg-success">
                                            {{ $appointment->format('F d,Y') }} <br>
                                            {{ $appointment->format('H:i a') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">PENDING <i
                                                class="bi bi-hourglass-bottom text-white"></i></span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $item->subject }}</td>
                            <td>{{ $item->reason }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <a class="badge bg-danger cancel_request" data-value="{{ $item->appointment_id }}">
                                        <i class="bi bi-x-circle" style="color: white;"> CANCEL <br> REQUEST </i>
                                    </a>
                                @elseif($item->status === 3)
                                    <a class="badge bg-primary appointmentDetailsFull" data-bs-toggle="modal"
                                        data-bs-target="#appointmentDetailsFull"
                                        data-value="{{ $item->appointment_id }}">
                                        VIEW
                                    </a>
                                @elseif($item->status === 4)
                                    <a class="badge bg-primary appointmentDetailsFull" data-bs-toggle="modal"
                                        data-bs-target="#appointmentDetailsFull"
                                        data-value="{{ $item->appointment_id }}">
                                        VIEW
                                    </a>
                                @endif


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>
</div>
{{-- Add Form Modal --}}
<div class="modal fade" id="modalRequestFormAppointment" tabindex="-1"
    aria-labelledby="modalRequestFormAppointmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <label for=""
                    class="fw-bolder text-primary h4">{{ strtoupper('Appointment on Guidance') }}</label>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.request.appointment.v2') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <small for="subject" class="text-muted fw-bolder">SUBJECT:</small>
                        <select name="subject" id="" class="form-select border border-primary">
                            <option value="">Select Subject for Appointment</option>
                            @foreach ($subjects as $item)
                                <option value="{{ $item }}" {{ old('subject') == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject')
                            <div class="badge bg-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <small for="reason" class="text-muted fw-bolder">REASON:</small>
                        <textarea class="form-control border border-primary" id="reason" name="reason" rows="4">{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="badge bg-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary float-end">SUBMIT REQUEST</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="appointmentDetailsFull" tabindex="-1" aria-labelledby="appointmentDetailsFullLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5 fw-bolder text-primary" id="appointmentDetailsFullLabel">APPOINTMENT DETAILS</h3>
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
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">START SESSION</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary scheduled-start-session"></label>
                    </div>
                    <div class="col-md">
                        <small class="fw-bolder text-muted">END SESSION</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary  scheduled-end-session"></label>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.appointmentDetailsFull', function() {
        var id = $(this).data('value');
        $('.appointmentInput').val(id);
        $.get('/user/appointment/details?value=' + id, function(response) {
            console.log(response)
            if (response.appointment) {
                let appointment = response.appointment
                $('.subject').text(appointment.subject)
                $('.request-date').text(convertDate(appointment.created_at))
                $('.reason').text(appointment.subject)
                $('.scheduled-date').text(appointment.appointment_date)
                $('.scheduled-time').text(appointment.appointment_time)
                $('.scheduled-start-session').text(appointment.appointment_time_from)
                $('.scheduled-end-session').text(appointment.appointment_time_to)

            }
        })
    })

    function convertDate(date1) {
        const date = new Date(date1);

        if (isNaN(date.getTime())) {
            return "Invalid Date"; // Handle incorrect inputs gracefully
        }

        // Define months array for conversion
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        // Extract components
        const month = months[date.getMonth()];
        const day = date.getDate();
        const year = date.getFullYear();

        let hours = date.getHours();
        const minutes = date.getMinutes().toString().padStart(2, "0"); // Ensure 2-digit format
        const ampm = hours >= 12 ? "PM" : "AM";

        // Convert to 12-hour format
        hours = hours % 12 || 12;

        // Format the final string
        const formattedDate = `${month} ${day} ${year} ${hours}:${minutes} ${ampm}`;

        console.log(formattedDate);
        return formattedDate;
    }
</script>
