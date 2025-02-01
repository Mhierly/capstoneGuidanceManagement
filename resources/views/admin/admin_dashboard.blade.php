@extends('layouts.app')
@section('title-page', 'Dashboard')
@section('content')

    <style>
        .card-header {
            background-color: #001247;
        }

        .card-body {
            background-color: #4169e1;
            color: #ffff;
        }
    </style>
    <div class="container">
        <p class="display-6 fw-bolder text-primary">DASHBOARD</p>
        <div class="row">
            <div class="col-md-12 col-lg-4 row">
                <div class="col-lg-12 col-md-6">
                    <div class="card mb-4 shadow" title="Tracking the user accounts handled by administrator/counselors.">
                        <div class="card-header text-white">User Accounts
                            <i class="fas fa-question-circle float-end text-warning"
                                title="Tracking the user accounts handled by administrator/counselors."></i>
                        </div>
                        <div class="card-body">
                            <h1 class="text-center">{{ $data['no_of_students'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header text-white">Number of Cases
                            <i class="fas fa-question-circle float-end text-warning"
                                title="Tracking the number of cases or incidents handled by administrators /counselors."></i>
                        </div>
                        <div class="card-body">
                            <h1 class="text-center">{{ $data['no_of_cases'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header text-white">Number of Request Forms
                            <i class="fas fa-question-circle float-end text-warning"
                                title="Tracking the number of request forms handled by administrators/ counselors."></i>
                        </div>
                        <div class="card-body">
                            <h1 class="text-center">{{ $data['no_of_request_forms'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="card mb-4 shadow">
                        <div class="card-header text-white">Completed Appointments
                            <i class="fas fa-question-circle float-end text-warning"
                                title="Tracking the completed appointments handled by administrators/ counselors."></i>
                        </div>
                        <div class="card-body">
                            <h1 class="text-center">{{ $data['completed_appointments'] }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center text-white">Appointment Calendar</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar-appointment"></div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('login_success'))
            Swal.fire({
                title: 'Welcome Admin!',
                text: "{{ session('login_success') }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('ErrorMsg'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('ErrorMsg') }}",
                icon: 'error',
                confirmButtonText: 'OK'
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
            $('#calendar-appointment').fullCalendar({
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
    </script>
@endsection
