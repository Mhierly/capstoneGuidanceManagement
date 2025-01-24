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
                                    @if ($item->appointment_date == null)
                                        <span class="badge bg-success">
                                            {{ $item->appointment_date }}
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
