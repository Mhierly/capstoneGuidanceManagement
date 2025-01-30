@extends('layouts.app')
@section('title-page', 'Student Information')
@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <p class="display-6 fw-bolder text-primary">STUDENT INFORMATION </p>
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
                                            href="{{ route('admin.viewReports', ['student' => request()->input('student'), 'category' => 'profile']) }}">
                                            <i class="bi bi-person-circle me-2"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-around">

                                            <button id="email_student_btn" class="btn btn-info me-2" data-id="3"><i
                                                    class="bi bi-send" style="color: white;"></i></button>
                                            <a href="{{ route('admin.studentInformationPDF', ['student' => $student->id]) }}"
                                                class="btn btn-success" target="_blank">
                                                <i class="bi bi-eye" style="color: white;"></i>
                                            </a>
                                        </div>
                                    </li>
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
                                    <small class="badge bg-secondary">
                                        STUDENT ID
                                    </small> |
                                    <small class="badge bg-secondary">
                                        EMAIL
                                    </small><br>
                                    <small class="badge bg-secondary">
                                        LRN
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg col-md-12">
            <form>
                <label for="" class="text-primary fw-bolder">SEARCH STUDENT</label>
                <div class="form-group">
                    <input type="search" class="form-control form-control-sm border border-primary searchStudent"
                        placeholder="Search...">
                </div>
            </form>
            <div class="student-list mt-2">
                @forelse ($studentList as $item)
                    <div class="card mb-2">
                        <a
                            href="{{ route('admin.viewStudentList', ['student' => $item['id'], 'category' => 'profile']) }}">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ $item['image'] }}" width="100%" class="avatar-100 rounded"
                                        alt="applicant-profile">
                                </div>
                                <div class="col-md p-1">
                                    <div class="card-body p-2">
                                        <small class="text-primary fw-bolder">{{ strtoupper($item['name']) }}</small>
                                        <br>
                                        <small class="text-muted fw-bolder">{{ $item['email'] }}</small>
                                        <br>
                                        @if (!$item['status'])
                                            <span class="badge bg-secondary">NEED TO UPDATE
                                                <i class="bi bi-hourglass-bottom text-white"></i>
                                            </span>
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
                                    <small class="text-muted fw-bolder">EMAIL</small>
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


    @include('layouts.loading');
    <script>
        $(document).ready(function() {
            @if (session('error_request'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error_request') }}'
                });
            @elseif (session('success_request'))
                Swal.fire({
                    icon: 'success',
                    title: 'Request sent!',
                    text: '{{ session('success_request') }}'
                });
            @endif
        })
        $(document).on('keydown', '.searchStudent', function() {

        });
    </script>
@endsection
