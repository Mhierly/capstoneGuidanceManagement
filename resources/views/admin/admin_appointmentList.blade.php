@extends('layouts.app')
@section('title-page', 'Student Appointment Request')
@section('content')
    <div class="container mb-3">
        <h1 class="text-primary fw-bolder">STUDENT APPOINTMENT</h1>
        <div class="row">

            <div class="col-md">
                @if (request()->input('student'))
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{ $student->studentProfile() }}" class="avatar-130 rounded" style="width:80%"
                                    alt="applicant-profile">
                            </div>
                            <div class="col-md ps-0">
                                <div class="card-body p-3 me-2">
                                    @php
                                        $applicantName = $student
                                            ? ($student
                                                ? strtoupper($student->lastname . ', ' . $student->firstname)
                                                : strtoupper($student->name))
                                            : 'MIDSHIPMAN NAME';
                                    @endphp
                                    <label for="" class="fw-bolder text-primary h3">{{ $applicantName }}</label>
                                    <p class="mb-0">
                                        @if ($student)
                                            <small class="badge bg-primary">
                                                {{ $student->school_id }}
                                            </small> |
                                            <small class="badge bg-primary">
                                                {{ $student->account->email }}
                                            </small><br>
                                            <small class="badge bg-primary">
                                                @if ($student->lrn)
                                                    {{ $student->lrn }}
                                                @else
                                                    {{ '(LRN to be updated)' }}
                                                @endif
                                            </small>
                                        @endif
                                    </p>
                                    <ul class="list-unstyled d-flex justify-content-around mt-3 text-muted">
                                        <li
                                            class="{{ request()->input('category') == 'profile' ? 'text-primary fw-bolder' : 'text-muted' }} w-100">
                                            <a
                                                href="{{ route('admin.viewAppointments', ['student' => request()->input('student'), 'category' => 'profile']) }}">
                                                <i class="bi bi-person-circle me-2"></i> Profile
                                            </a>
                                        </li>
                                        <li
                                            class="{{ request()->input('category') == 'appointment' ? 'text-primary fw-bolder' : 'text-muted' }} w-100">
                                            <a
                                                href="{{ route('admin.viewAppointments', ['student' => request()->input('student'), 'category' => 'appointment']) }}">
                                                <i class="bi bi-calendar-event me-2"></i> Appointment
                                            </a>
                                        </li>
                                        {{--   <li>
                                            <a href="">
                                                <i class="bi bi-award-fill me-2"></i> Good Moral
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="bi bi-file-earmark-x-fill me-2"></i> Drop Request
                                            </a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (request()->input('category') == 'profile')
                        @include('cardWidgets.studentProfile')
                    @else
                        @include('cardWidgets.studentAppointment')
                    @endif
                @else
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <img src="{{ asset('img/male.jpg') }}" class="card-img" alt="#">
                            </div>
                            <div class="col-md ps-0">
                                <div class="card-body p-3 me-2">
                                    <h4 class="card-title text-primary fw-bolder">
                                        STUDENT'S NAME
                                    </h4>
                                    <p class="mb-0">
                                        <small class="badge bg-primary">
                                            STUDENT ID
                                        </small> |
                                        <small class="badge bg-primary">
                                            EMAIL
                                        </small><br>
                                        <small class="badge bg-primary">
                                            LRN
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-md-4">
                <a class="btn btn-primary w-100 viewCalendar" data-bs-toggle="modal" data-bs-target="#viewCalendar">
                    APPOINTMENT CALENDAR
                </a>
                <small class="fw-bolder text-primary mt-3">APPOINTMENT REQUEST LIST</small>
                <div class="card">
                    <div class="card-body">
                        <small class="fw-bolder text-muted">STATUS</small>
                        <select name="" id=""
                            class="form-select form-select-sm border border-primary select-status">
                            <option value="1" selected>PENDING</option>
                            <option value="2">CANCEL</option>
                            <option value="3">APPROVED</option>
                            <option value="4">COMPLETED</option>
                        </select>
                    </div>
                </div>
                <div class="appointment-list mt-3">
                    @forelse ($appointmentList as $item)
                        <div class="card mb-2">
                            <a
                                href="{{ route('admin.viewAppointments', ['student' => $item->appointment_id, 'category' => 'appointment']) }}">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="{{ $item->student->studentProfile() }}" width="100%"
                                            class="avatar-100 rounded" alt="applicant-profile">
                                    </div>
                                    <div class="col-md p-1">
                                        <div class="card-body p-2">
                                            <small
                                                class="text-primary fw-bolder">{{ strtoupper($item->student->lastname . ', ' . $item->student->firstname) }}</small>
                                            <br>
                                            <small class="text-muted fw-bolder">{{ $item->subject }}</small>
                                            <br>
                                            @if ($item->status === 1)
                                                <span class="badge bg-secondary">PENDING <i
                                                        class="bi bi-hourglass-bottom text-white"></i></span>
                                                {{--  @elseif($item->status === 2)
                                            <span class="badge bg-danger">CANCELLED <i
                                                    class="bi bi-x-circle text-white"></i></span>
                                        @elseif($item->status === 3)
                                            <span class="badge bg-success">APPROVED <i
                                                    class="bi bi-check-circle text-white"></i></span>
                                        @elseif($item->status === 4)
                                            <span class="badge bg-primary">COMPLETED <i
                                                    class="bi bi-check-circle-fill text-white"></i></span> --}}
                                            @else
                                                {{ $item->status }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="card mt-2">
                            <div class="row no-gutters">
                                <div class="col-md-4">

                                </div>
                                <div class="col-md p-1">
                                    <div class="card-body p-2">
                                        <small class="text-muted fw-bolder">STUDENT NAME</small>
                                        <br>
                                        <small class="text-muted fw-bolder">SUBJECT</small>
                                        <br>
                                        <span class="badge bg-muted"> STATUS <i
                                                class="bi bi-check-circle-fill text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
   
    <div class="modal fade" id="viewCalendar" tabindex="-1" aria-labelledby="viewCalendarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5 fw-bolder text-primary" id="viewCalendarLabel">APPOINTMENT CALENDAR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.student_profile')
    @include('layouts.loading')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#appointmentList').DataTable({
                scrollY: '50vh',
                processing: true,
                serverSide: true,
                ajax: {
                    method: 'get',
                    url: "{{ route('fetch.counselor.appointment.requests') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'appointment_status',
                        name: 'appointment_status'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'formatted_appointment_date',
                        name: 'formatted_appointment_date'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'reason',
                        name: 'reason'
                    },
                    {
                        data: 'formatted_requested_date',
                        name: 'formatted_requested_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.status == 1) {
                        $(row).addClass('bg-secondary text-white'); // Pending
                    } else if (data.status == 2) {
                        $(row).addClass('bg-danger text-white'); // Rejected
                    } else if (data.status == 3) {
                        $(row).addClass('bg-success text-white'); // Approved
                    } else if (data.status == 4) {
                        $(row).addClass('bg-primary text-white'); // Finalized
                    }
                },
                columnDefs: [{
                        targets: 1,
                        orderable: false,
                        searchable: false
                    } // Adjust the column index as needed
                ]
            });

            $('#student_info_modal').on('show.bs.modal', function(event) {
                var id = $(event.relatedTarget).data('id');

                var url_img = "{{ route('student.image', ['id' => ':id']) }}".replace(':id', id);
                $('#student_profile_img').attr('src', url_img);

                $('#student_profile_img').on('error', function() {
                    console.error('Image not found at ' + url_img);
                    $(this).attr('src', "{{ asset('img/default.jpg') }}");
                });

                $.ajax({
                    url: '{{ route('student.information', ['id' => ':id']) }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            $('#student_last_update').html('(Last update: ' + response
                                .last_update + ')');
                            $('#student_name').html(response.firstname + ' ' + (response
                                    .middlename ? response.middlename : '') + ' ' + response
                                .lastname + (response.suffix ? response.suffix : '') +
                                ' <small class="text-secondary">' + (response.school_id ?
                                    response.school_id : '') + '</small>');
                            $('#student_grade_level').html(response.current_grade);
                            $('#student_section').html(response.current_section);
                            $('#student_address').html((response.house_no_street ? response
                                .house_no_street + ', ' : '') + (response.baranggay ?
                                response.baranggay + ', ' : '') + (response
                                .municipality ? response.municipality + ', ' : '') + (
                                response.province ? response.province : ''));
                            $('#student_lrn').html((response.lrn ? response.lrn :
                                '<span class="text-danger">(Need to update student LRN)</span>'
                            ));
                            $('#student_age').html(response.age);
                            $('#student_fullname').html(response.firstname + ' ' + (response
                                    .middlename ? response.middlename : '') + ' ' + response
                                .lastname);
                            $('#student_email').html(response.email);
                            $('#student_contact').html((response.contact_no ? response
                                .contact_no :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_sex').html((response.sex ? response.sex :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_birthdate').html((response.birthday ? response
                                .birthday :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_religion').html((response.religion ? response.religion :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_nationality').html((response.nationality ? response
                                .nationality :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_father').html((response.father ? response.father :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_father_occupation').html((response.father_occupation ?
                                response.father_occupation :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_mother').html((response.mother ? response.mother :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_mother_occupation').html((response.mother_occupation ?
                                response.mother_occupation :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_living_with').html((response.living_with ? response
                                .living_with :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_no_of_siblings').html(response.no_of_siblings +
                                ' <span>(' + response.position + ')</span>');
                            $('#student_elem_school').html((response.elem_school ? response
                                .elem_school :
                                '<span class="text-danger">(Need to update)</span>'));
                            $('#student_gen_average').html(response.gen_average);
                            if (response.current_grade == 'Grade 7') {
                                $('#student_current_grade').html('Grade 6');
                            } else if (response.current_grade == 'Grade 8') {
                                $('#student_current_grade').html('Grade 7');
                            } else if (response.current_grade == 'Grade 9') {
                                $('#student_current_grade').html('Grade 8');
                            } else if (response.current_grade == 'Grade 10') {
                                $('#student_current_grade').html('Grade 9');
                            }

                            $('#student_school_id_2').html(response.school_id);
                            $('#student_adviser').html((response.adviser ? response.adviser :
                                '<span class="text-danger">(Need to update)</span>'));

                        } else {
                            console.log('No data found');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '#update_status_btn', function() {
                var id = $(this).data('id');
                var status_name = $(this).data('name');
                var appointment_id = $(this).data('appointment');

                Swal.fire({
                    title: 'Update Dropping Status',
                    text: 'Update the current status into ' + '"' + status_name + '"',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#0000FF',
                    cancelButtonColor: '#ddd',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        $.ajax({
                            url: '{{ route('admin.student.appointment.status') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                appointment_id: appointment_id,
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(response) {
                                if (response == 'not available') {
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: 'Date and time of the request is not available.',
                                        icon: 'error'
                                    }).then(() => {
                                        table.ajax.reload();
                                    });
                                } else if (response == 'overlap') {
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: 'Overlapping date and time!',
                                        icon: 'error'
                                    }).then(() => {
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response,
                                        icon: 'success'
                                    }).then(() => {
                                        table.ajax.reload();
                                    });
                                }
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
                        });
                    }
                });
            });

            $(document).on('click', '#email_appointment', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Email?',
                    text: 'Email appointment to student.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#rrr',
                    cancelButtonColor: '#ddd',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        $.ajax({
                            url: '{{ route('admin.student.appointment.email') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response,
                                    icon: 'success'
                                })
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
                        });
                    }
                });
            });

            $(document).on('click', '#delete_appointment_item', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Delete?',
                    text: 'You will not be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    cancelButtonColor: '#ddd',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        $.ajax({
                            url: '{{ route('admin.student.appointment.remove') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response,
                                    icon: 'success'
                                }).then(() => {
                                    table.ajax.reload();
                                });
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
                        });
                    }
                });
            });
            $(document).on('change', '.select-status', function() {
                let status = $('.select-status').val()
                $('.appointment-list').empty();

                $.get('/admin/student/appointment/status?status=' + status, function(response) {
                    if (Array.isArray(response.appointmentList)) {
                        response.appointmentList.forEach(function(item) {
                            let cardHtml = `
            <div class="card mb-2">
                <a href="/admin/appointments?student=${item.appointment_id}&category=appointment">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="${item.image}" width="100%" class="avatar-100 rounded" alt="applicant-profile">
                        </div>
                        <div class="col-md p-1">
                            <div class="card-body p-2">
                                <small class="text-primary fw-bolder">${item.name}</small>
                                <br>
                                <small class="text-muted fw-bolder">${item.appointment_subject}</small>
                                <br>
                                ${getStatusBadge(item.appointment_status)}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;

                            $('.appointment-list').append(cardHtml);
                        });
                    } else {
                        $('.appointment-list').append(`
                        <div class="card mt-2">
                            <div class="row no-gutters">
                                <div class="col-md-4">

                                </div>
                                <div class="col-md p-1">
                                    <div class="card-body p-2">
                                        <small class="text-muted fw-bolder">STUDENT NAME</small>
                                        <br>
                                        <small class="text-muted fw-bolder">SUBJECT</small>
                                        <br>
                                        <span class="badge bg-muted"> STATUS <i
                                                class="bi bi-check-circle-fill text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        `)
                    }

                })
            });

            function getStatusBadge(status) {
                switch (status) {
                    case 1:
                        return `<span class="badge bg-secondary">PENDING <i class="bi bi-hourglass-bottom text-white"></i></span>`;
                    case 2:
                        return `<span class="badge bg-danger">CANCELLED <i class="bi bi-x-circle text-white"></i></span>`;
                    case 3:
                        return `<span class="badge bg-success">APPROVED <i class="bi bi-check-circle text-white"></i></span>`;
                    case 4:
                        return `<span class="badge bg-primary">COMPLETED <i class="bi bi-check-circle-fill text-white"></i></span>`;
                    default:
                        return status;
                }
            }
        });
    </script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @elseif (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Request sent!',
                text: '{{ session('success') }}'
            });
        @endif
    </script>
    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            let event = <?php echo json_encode($events); ?>;
            console.log(event)
            $('.viewCalendar').click(function() {
                $('#calendar').fullCalendar({
                    defaultView: 'agendaWeek',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    events: event,
                    slotDuration: '01:00:00', // Set the slot duration to 1 hour
                    slotLabelInterval: '01:00', // Show labels for every hour
                    allDaySlot: false, // Disable the All Day slot
                    minTime: '06:00:00',
                    maxTime: '22:00:00',
                    editable: true,
                    droppable: true,
                    height: 'auto',
                    viewRender: function(view, element) {
                        if (view.name === 'agendaWeek') {
                            // This will hide the event data in the agendaWeek view
                            $(element).find('.fc-event').hide();
                        }
                    }
                });
            })

        })
    </script>
@endsection
