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

                                            <button id="email_student_btn" class="btn btn-info me-2"
                                                data-id="{{ $student->id }}"><i class="bi bi-send"
                                                    style="color: white;"></i></button>
                                            <a href="{{ route('admin.studentInformationPDF', ['student' => $student->id]) }}"
                                                class="btn btn-success" target="_blank">
                                                <i class="bi bi-eye" style="color: white;"></i>
                                            </a>
                                            <button class="btn" id="student_editor_btn" data-id="{{ $student->id }}"
                                                data-bs-toggle="modal" data-bs-target="#student_editor_modal"
                                                style="background-color:  #ffc107;color:#fff;"><i
                                                    class="bi bi-pencil-square" style="color: white;"></i></button>
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
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade" id="student_editor_modal" tabindex="-1" aria-labelledby="student_editor_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="student_editor_modalLabel">Edit Student Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_student_form" class="row g-3" method="POST"
                        action="{{ route('admin.student.update') }}">
                        @csrf
                        <input type="text" name="student_id" id="student_id" hidden>
                        <div class="col-md-12">
                            <label for="lrn" class="form-label">Learner Reference Number <small
                                    class="text-danger">(12-digit number)</small></label>
                            <input type="text" id="lrn" class="form-control" name="lrn" pattern="\d{12}"
                                title="Please enter a 12-digit number" maxlength="12" oninput="validateLRN(this)"
                                placeholder="(Need to update)" required>
                        </div>
                        <div class="col-md-6">
                            <label for="elem_school" class="form-label">Elementary School Graduate</label>
                            <input type="text" id="elem_school" class="form-control" name="elem_school"
                                placeholder="(Need to update)">
                        </div>
                        <div class="col-md-6">
                            <label for="gen_average" class="form-label">Student General Average</label>
                            <input type="number" min="50" max="100" id="gen_average" name="gen_average"
                                class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="current_grade_options" class="form-label">Student Current Grade</label>
                            <select id="current_grade_options" class="form-select" name="current_grade_options">
                                @php
                                    foreach ($grade_levels as $level) {
                                        echo "<option value=\"$level->id\">$level->grade_level</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="current_section_options" class="form-label">Student Current Section</label>
                            <select id="current_section_options" class="form-select" name="current_section_options">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="adviser" class="form-label">Adviser</label>
                            <select id="adviser" class="form-select" name="adviser">
                                <option value="0" selected disabled>Select</option>
                                @php
                                    foreach ($advisers as $adviser) {
                                        echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
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
            $(document).on('keyup', '.searchStudent', function(evt) {
                evt.preventDefault()
                let search = $('.searchStudent').val();
                $('.student-list').empty();

                $.get('/fetch-search-student?search=' + search, function(response) {
                    console.log(response.studentList);
                    if (response.studentList.length > 0) {
                        response.studentList.forEach(function(item) {
                            let cardHtml = `
            <div class="card mb-2">
                <a href="/admin/students/v2?student=${item .id}&category=profile=">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="${item.image}" width="100%" class="avatar-100 rounded" alt="applicant-profile">
                        </div>
                        <div class="col-md p-1">
                            <div class="card-body p-2">
                                <small class="text-primary fw-bolder">${item.name}</small>
                                <br>
                                <small class="text-muted fw-bolder">${item.email}</small>
                                <br>
                                ${getStatusBadge(item.status)}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;

                            $('.student-list').append(cardHtml);
                        });
                    } else {
                        $('.student-list').append(
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
                });

                console.log(search);
            });


        });
        $('#student_editor_modal').on('show.bs.modal', function(event) {
            var id = $(event.relatedTarget).data('id');
            $('#student_id').val(id);

            $.ajax({
                url: '{{ route('student.information', ['id' => ':id']) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    if (response) {
                        $('#lrn').val(response.lrn);
                        $('#elem_school').val(response.elem_school);
                        $('#gen_average').val(response.gen_average);
                        $('#current_grade_options').val(response.current_grade_id).change();
                        $('#adviser').val(response.adviser_id).change();

                        fetchSections(response.current_grade_id, response.current_section_id);

                        $('#current_grade_options').on('change', function() {
                            var grade = $('#current_grade_options').val();
                            fetchSections(grade, response.current_section_id);
                        });

                    } else {
                        console.log('No data found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        function validateLRN(input) {
            if (input.value.length > 12) {
                input.value = input.value.slice(0, 12);
            }
        }

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

        function fetchSections(grade, current_section) {
            $.ajax({
                type: 'GET',
                url: '{{ route('fetch.sections', ['id' => ':id']) }}'.replace(':id', grade),
                success: function(sections) {
                    var current_section_options = $('#current_section_options');
                    current_section_options.empty();

                    $.each(sections, function(index, section) {
                        var selected = (section.id == current_section) ? 'selected' : '';
                        current_section_options.append('<option value="' + section.id + '" ' +
                            selected + '>' + section.section_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        $(document).on('click', '#email_student_btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Email?',
                text: 'Notify student about account completion.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: '{{ route('admin.student.email') }}',
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                                xhr
                                .responseJSON.error :
                                'There was an error processing your request.';
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            hideLoading();
                        }
                    });
                }
            });
        });
    </script>
@endsection
