@extends('layouts.app')
@section('title-page', 'Student Concern')
@section('content')
    <div class="container mb-3">
        <h1 class="text-primary fw-bolder">STUDENT CONCERN</h1>
        <div class="row">

            <div class="col-md">
                @if ($student)
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
                                                href="{{ route('admin.viewReports', ['view' => request()->input('view'), 'category' => 'profile']) }}">
                                                <i class="bi bi-person-circle me-2"></i> Profile
                                            </a>
                                        </li>
                                        <li
                                            class="{{ request()->input('category') == 'concern' ? 'text-primary fw-bolder' : 'text-muted' }} w-100">
                                            <a
                                                href="{{ route('admin.viewReports', ['view' => request()->input('view'), 'category' => 'concern']) }}">
                                                <i class="bi bi-calendar-event me-2"></i> Report Concern
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
                    @elseif(request()->input('category') == 'concern')
                        @include('cardWidgets.studentConcern')
                    @else
                        @include('cardWidgets.studentProfile')
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
            <div class="col-lg-4 col-md-12">
                <small class="fw-bolder text-primary">LIST OF STUDENT CONCERN</small>
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

                        <a href="{{ route('admin.concernList') }}" target="_blank"
                            class="btn btn-primary w-100 mt-2">GENERATE REPORT</a>
                    </div>
                </div>
                <div class="appointment-list mt-3">
                    @forelse ($concernList as $item)
                        <div class="card mb-2">
                            <a
                                href="{{ route('admin.viewReports', ['view' => $item['concern_id'], 'category' => 'concern']) }}">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="{{ $item['complainantImage'] }}" width="100%"
                                            class="avatar-100 rounded" alt="applicant-profile">
                                    </div>
                                    <div class="col-md p-1">
                                        <div class="card-body p-2">
                                            <small
                                                class="text-primary fw-bolder">{{ strtoupper($item['complainant']) }}</small>
                                            <br>
                                            <small class="text-muted fw-bolder">{{ $item['main_concern'] }}</small>
                                            <br>
                                            @if ($item['status'] === 1)
                                                <span class="badge bg-secondary">PENDING <i
                                                        class="bi bi-hourglass-bottom text-white"></i></span>
                                            @elseif($item['status'] === 2)
                                                <span class="badge bg-danger">CANCELLED <i
                                                        class="bi bi-x-circle text-white"></i></span>
                                            @elseif($item['status'] === 3)
                                                <span class="badge bg-success">APPROVED <i
                                                        class="bi bi-check-circle text-white"></i></span>
                                            @elseif($item['status'] === 4)
                                                <span class="badge bg-primary">COMPLETED <i
                                                        class="bi bi-check-circle-fill text-white"></i></span>
                                            @else
                                                {{ $item['status'] }}
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
    @include('layouts.loading');
    <script>
        $(document).ready(function() {
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
        })
        $(document).on('change', '.select-status', function() {
            let data = $('.select-status').val()
            $('.appointment-list').empty();
            $.get('/fetch-concern-report?status=' + data, function(response) {
                console.log(response)
                if (response.concernList.length > 0) {
                    response.concernList.forEach(function(item) {
                        let cardHtml = `
                         <div class="card mb-2">
                <a href="/admin/reports/v2?view=${item.concern_id}&category=concern">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="${item.complainantImage}" width="100%" class="avatar-100 rounded" alt="applicant-profile">
                        </div>
                        <div class="col-md p-1">
                            <div class="card-body p-2">
                                <small class="text-primary fw-bolder">${item.complainant}</small>
                                <br>
                                <small class="text-muted fw-bolder">${item.main_concern}</small>
                                <br>
                                ${getStatusBadge(item.status)}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
                        `
                        $('.appointment-list').append(cardHtml);
                    })
                } else {
                    $('.appointment-list').append(
                        `<div class="card mt-2">
                                <div class="row no-gutters">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md p-1">
                                        <div class="card-body p-2">
                                            <small class="text-muted fw-bolder">NO DATA</small>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>`
                    )
                }
            })
        })

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
    </script>
@endsection
