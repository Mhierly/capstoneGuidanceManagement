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
        <h3 class="text-center mb-4">Dashboard</h3>
        <div class="row">
            <div class="col-md">
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
            <div class="col-md">
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
            <div class="col-md">
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
            <div class="col-md">
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
        <div class="mt-5">
            <h3 class="text-center">Appointment Calendar</h3>
            <div id="calendar"></div>
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    slotMinTime: '8:00:00',
                    slotMaxTime: '18:00:00',
                    height: 'auto',
                    events: @json($events),
                });
                calendar.render();

            });
        </script>
    @endpush

@endsection
