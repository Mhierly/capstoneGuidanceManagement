@extends('layouts.app')
@section('title-page', 'Report Concern')
@section('content')
    <div class="container">
        <h1 class="text-primary fw-bolder">REPORT CONCERN</h1>
        <div class="row">
            <div class="col-lg col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label for="" class="fw-bolder text-primary h4">CREATE REPORT CONCERN</label>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.request.report') }}" method="post">
                            @csrf
                            <label for="" class="fw-bolder text-primary h5">| IDENTIFYING INFORMATION</label>
                            <div class="form-group mb-3">
                                <label for="" class="fw-bolder text-muted">A. VICTIM</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small class="text-muted fw-bolder">
                                            NAME <span class="text-danger">*</span>
                                        </small>
                                        <input class="form-control form-control-sm border border-primary" type="text"
                                            name="victim_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bolder">
                                            AGE <span class="text-danger">*</span>
                                        </small>
                                        <input class="form-control form-control-sm border border-primary" type="number"
                                            min="0" max="99" name="victim_age">
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bolder">
                                            GENDER <span class="text-danger">*</span>
                                        </small>
                                        <select class="form-select form-select-sm border border-primary"
                                            name="victim_gender" id="victim_gender">
                                            <option value="None" disabled selected>Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <small class="text-muted fw-bolder">
                                            CLASS ADVISER<span class="text-danger">*</span>
                                        </small>
                                        <select class="form-select form-select-sm border border-primary"
                                            name="victim_class_adviser">
                                            <option value="1" disabled selected>Select Adviser</option>
                                            @php
                                                foreach ($advisers as $adviser) {
                                                    echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <small class="text-muted fw-bolder">
                                            GRADE AND SECTION <span class="text-danger">*</span>
                                        </small>
                                        <div class="row">
                                            <div class="col-md">
                                                <select class="form-select form-select-sm border border-primary"
                                                    name="victim_grade" id="victim_grade">
                                                    <option value="1" disabled selected>Select Grade Level</option>
                                                    @php
                                                        foreach ($grades as $grade) {
                                                            echo "<option value=\"$grade->id\">$grade->grade_level</option>";
                                                        }
                                                    @endphp
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <select class="form-select form-select-sm border border-primary"
                                                    name="victim_section" id="victim_section">
                                                    <option value="1" disabled selected>Select Section</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <small class="text-muted fw-bolder">
                                            PARENT'S / GUARDIAN<span class="text-danger">*</span>
                                        </small>
                                        <input type="text" name="victim_parent_guardian"
                                            class="form-control form-control-sm border border-primary">
                                    </div>
                                    <div class="col-md">
                                        <small class="text-muted fw-bolder">
                                            CONTACT NUMBER<span class="text-danger">*</span>
                                        </small>
                                        <input type="number" min="0" name="victim_parent_contact"
                                            class="form-control form-control-sm border border-primary">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="fw-bolder text-muted">B.COMPLAINANT</label>
                                <div class="row">
                                    <input hidden readonly value="{{ $student->id }}" type="text" name="complainant_id"
                                        id="complainant_id" style="width: 273px;">

                                    <div class="col-md">
                                        <small class="text-muted fw-bolder">
                                            NAME<span class="text-danger">*</span>
                                        </small>

                                        <input readonly value="{{ $student->firstname . ' ' . $student->lastname }}"
                                            type="text" class="form-control form-control-sm border border-primary">
                                    </div>
                                    <div class="col-md">
                                        <small class="text-muted fw-bolder">
                                            RELATION TO THE VICTIM<span class="text-danger">*</span>
                                        </small>
                                        <input required type="text" name="relation_to_victim"
                                            class="form-control form-control-sm border border-primary">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="fw-bolder text-muted">C.OFFENDER/S</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small class="text-muted fw-bolder">
                                            NAME<span class="text-danger">*</span>
                                        </small>
                                        <input required type="text" name="offender_name"
                                            class="form-control form-control-sm border border-primary">

                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bolder">
                                            AGE<span class="text-danger">*</span>
                                        </small>
                                        <input required type="number" min="0" max="99" name="offender_age"
                                            class="form-control form-control-sm border border-primary">
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-bolder">
                                            GENDER<span class="text-danger">*</span>
                                        </small>
                                        <select name="offender_gender"
                                            class="form-select form-select-sm border border-primary">
                                            <option value="None" disabled selected>Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <small class="text-muted fw-bolder">
                                                CLASS ADVISER<span class="text-danger">*</span>
                                            </small>
                                            <select class="form-select form-select-sm border border-primary"
                                                name="victim_class_adviser">
                                                <option value="1" disabled selected>Select Adviser</option>
                                                @php
                                                    foreach ($advisers as $adviser) {
                                                        echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <small class="text-muted fw-bolder">
                                                GRADE AND SECTION <span class="text-danger">*</span>
                                            </small>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-select form-select-sm border border-primary"
                                                        name="offender_grade" id="offender_grade">
                                                        <option value="1" disabled selected>Select Grade Level
                                                        </option>
                                                        @php
                                                            foreach ($grades as $grade) {
                                                                echo "<option value=\"$grade->id\">$grade->grade_level</option>";
                                                            }
                                                        @endphp
                                                    </select>
                                                </div>
                                                <div class="col-md">
                                                    <select class="form-select form-select-sm border border-primary"
                                                        name="offender_section" id="offender_section">
                                                        <option value="1" disabled selected>Select Section</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <small class="text-muted fw-bolder">
                                                PARENT'S / GUARDIAN<span class="text-danger">*</span>
                                            </small>
                                            <input type="text" name="offender_parent_guardian"
                                                class="form-control form-control-sm border border-primary">
                                        </div>
                                        <div class="col-md">
                                            <small class="text-muted fw-bolder">
                                                CONTACT NUMBER<span class="text-danger">*</span>
                                            </small>
                                            <input type="number" min="0" name="offender_parent_contact"
                                                class="form-control form-control-sm border border-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label for="" class="fw-bolder text-primary h4">| PROBLEM PRESENTED</label>
                            <div class="description">
                                <textarea class="form-control form-control-sm border border-primary" name="main_concern" id="main_concern"
                                    cols="80" class="w-100"></textarea>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-secondary">Report Concern</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="" class="text-muted fw-bolder">LIST OF CONCERN</label>
                @forelse ($listConcern as $item)
                    <div class="card mb-2">
                        <div class="card-body">
                            <label for="" class="fw-bolder">{{ $item->victim_name }}</label> <br>
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
                            <label for="">Complainant Date: <span
                                    class="text-info fw-bolder">{{ $item->created_at->format('F d,Y') }}</span></label>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body">
                            <label for="" class="fw-bolder">No Data</label>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
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
        $(document).ready(function() {

            $('#victim_grade').on('change', function() {
                var grade = $('#victim_grade').val();
                fetchSections(grade, $('#victim_section'));
            });

            $('#offender_grade').on('change', function() {
                var grade = $('#offender_grade').val();
                fetchSections(grade, $('#offender_section'));
            });
        })

        function fetchSections(grade_id, select_section) {
            $.ajax({
                type: 'GET',
                url: '{{ route('fetch.user.sections', ['grade_id' => ':grade_id']) }}'.replace(':grade_id',
                    grade_id),
                success: function(sections) {
                    var current_section_options = select_section;
                    current_section_options.empty();

                    $.each(sections, function(index, section) {
                        current_section_options.append('<option value="' + section.id + '">' + section
                            .section_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection
