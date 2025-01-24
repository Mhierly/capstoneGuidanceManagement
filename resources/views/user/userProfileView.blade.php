@extends('layouts.app')
@section('title-page', 'Profile')
@section('content')
    <div class="container">
        <h1 class="text-primary fw-bolder">STUDENT INFORMATION</h1>
        <div class="row">
            <div class="col-md-5">
                @if ($student)
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{ $student->studentProfile() }}" class="avatar-130 rounded" style="width:100%"
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
                                    <label for="" class="fw-bolder text-primary h4">{{ $applicantName }}</label>
                                    <p class="mb-0">
                                        @if ($student)
                                            <small class="badge bg-primary">
                                                {{ $student->school_id }}
                                            </small>
                                            <small class="badge bg-primary">
                                                {{ $student->account->email }}
                                            </small>-
                                            <small class="badge bg-primary">
                                                @if ($student->lrn)
                                                    {{ $student->lrn }}
                                                @else
                                                    {{ '(LRN to be updated)' }}
                                                @endif
                                            </small>
                                        @endif
                                    </p>
                                    {{--  <div class="mt-2">
                                        @if ($student)
                                            <small class="badge  border border-secondary text-secondary"
                                                data-bs-toggle="modal" data-bs-target=".modal-change-course"
                                                data-bs-toggle="change course" title="">
                                                CHANGE COURSE
                                            </small>
                                            @if ($student->is_alumnia)
                                                <span class="badge bg-primary float-end">
                                                    BMA SENIOR HIGH ALUMNUS
                                                </span>
                                            @else
                                                @if ($student->applicant && $student->senior_high_school())
                                                    <button class="badge border border-primary text-primary"
                                                        id="btn-alumnia" data-id="{{ base64_encode($student->id) }}">
                                                        BMA SENIOR HIGH ALUMNUS
                                                    </button>
                                                @endif
                                                @if (Auth::user() && (Auth::user()->email == 'p.banting@bma.edu.ph' || Auth::user()->email == 'k.j.cruz@bma.edu.ph'))
                                                    <button class="badge border border-primary text-primary"
                                                        wire:click="dialogBoxSHS({{ $student->id }})">BMA</button>
                                                @endif
                                            @endif
                                        @endif
                                        <small class="badge  border border-info text-info" title="Reset Password"
                                            wire:click="resetPassword('{{ $student->id }}')">
                                            RESET PASSWORD
                                        </small>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <label for="" class="fw-bolder text-secondary">
                                SETTING <i class="bi bi-gear"></i>
                            </label>
                            <a data-bs-toggle="modal" data-bs-target="#edit_profile"
                                class="btn btn-primary btn-sm mt-2 w-100">UPDATE STUDENT
                                INFORMATION</a>
                            <a class="btn btn-primary btn-sm mt-2 w-100">UPDATE EDUCATION
                                BACKGROUND</a>
                        </div>
                    </div>
                @else
                @endif
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <label for=""
                            class="fw-bolder text-primary h4">{{ strtoupper('Personal Information') }}</label>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <section class="row">
                                <div class="form-group col-md-12">
                                    <small class="fw-bolder text-secondary">FULL NAME</small>
                                    <p class="form-control  form-control-sm border border-primary text-capitalize">
                                        {{ $student->firstname }}
                                        {{ $student->middlename }} {{ $student->lastname }}
                                        {{ $student->suffix }}</p>
                                </div>
                                <div class="form-group col-md">
                                    <small class="fw-bolder text-secondary">CONTACT NUMBER</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->contact_no)
                                            +63{{ $student->contact_no }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <small class="fw-bolder text-secondary">GENDER</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->sex)
                                            {{ $student->sex }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <small class="fw-bolder text-secondary">BIRTH DATE</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->birthday)
                                            @php
                                                $data = date('F j, Y', strtotime($student->birthday));
                                            @endphp
                                            {{ $data }}
                                        @else
                                            No birthday available
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md">
                                    <small class="fw-bolder text-secondary">NATIONALITY</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->nationality)
                                            {{ $student->nationality }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="form-group col-md">
                                    <small class="fw-bolder text-secondary">RELIGION</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->religion)
                                            {{ $student->religion }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>

                            </section>
                            <section class="row">
                                <label for="" class="fw-bolder text-primary">| PARENT'S INFORMATION</label>
                                <div class="form-group col-md-6">
                                    <small class="fw-bolder text-secondary">FATHER</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->father)
                                            {{ $student->father }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <small class="fw-bolder text-secondary">MOTHER</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->mother)
                                            {{ $student->mother }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <small class="fw-bolder text-secondary">FATHER OCCUPATION</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->father_occupation)
                                            {{ $student->father_occupation }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <small class="fw-bolder text-secondary">MOTHER OCCUPATION</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->mother_occupation)
                                            {{ $student->mother_occupation }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <small class="fw-bolder text-secondary">EMERGENCY CONTACT</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->emergency_contact)
                                            {{ $student->emergency_contact }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                    <small class="fw-bolder text-secondary">CURENLTY LIVING WITH</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->living_with)
                                            {{ $student->living_with }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="form-group col-md-4">
                                    <small class="fw-bolder text-secondary">NO. OF SIBLINGS (POSITION)</small>
                                    <p class="form-control form-control-sm border border-primary text-capitalize">
                                        @if ($student->no_of_siblings && $student->position)
                                            {{ $student->no_of_siblings }} ({{ $student->position }})
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>


                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- UPDATE INFORMATION MODAL --}}
    <div class="modal fade" id="edit_profile" tabindex="-1" aria-labelledby="edit_profileLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5 fw-bolder" id="edit_profileLabel">UPDATE PERSONAL INFORMATION</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_profile_form" class="row g-3" action="{{ route('student.profile.editor') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-form">
                            <div class="row">
                                <div class="col-md-12 text-center mb-2">
                                    <img src="{{ $student->studentProfile() }}" alt="Student Image" class=""
                                        width="110" height="110" style="object-fit: cover;">
                                    <input type="file" class="form-control form-control-sm border border-primary"
                                        name="profile_img" id="profile_img">
                                    <div id="file-error" class="text-danger mt-2" style="display:none;">Please select a
                                        valid
                                        image file (jpg, jpeg, png, gif).</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">LAST NAME <span
                                            class="text-danger">*</span></small>
                                    <input type="text" class="form-control form-control-sm border border-primary"
                                        name="profile_last_name" value="{{ $student->lastname }}">
                                    @error('profile_last_name')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">FIRST NAME <span
                                            class="text-danger">*</span></small>
                                    <input type="text" class="form-control form-control-sm border border-primary"
                                        name="profile_first_name" value="{{ $student->firstname }}">
                                    @error('profile_first_name')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">MIDDLE NAME <span
                                            class="text-danger">*</span></small>
                                    <input type="text" class="form-control form-control-sm border border-primary"
                                        name="profile_middle_name" value="{{ $student->middlename }}">
                                </div>
                                <div class="col-md-2 ">
                                    <small class="fw-bolder text-muted">SUFFIX <span class="text-danger">*</span></small>
                                    <input type="text" class="form-control form-control-sm border border-primary"
                                        name="profile_suffix" value="{{ $student->suffix }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">BIRTH DATE <span
                                            class="text-danger">*</span></small>
                                    <input type="date" class="form-control form-control-sm border border-primary"
                                        name="profile_birthdate" value="{{ $student->birthday }}">
                                    @error('profile_birthdate')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">GENDER <span class="text-danger">*</span></small>
                                    <select id="profile_gender" name="profile_gender"
                                        class="form-select form-select-sm border border-primary">
                                        <option disabled selected>SELECT GENDER</option>
                                        @php
                                            $genders = ['Male', 'Female', 'Other(s)'];
                                            foreach ($genders as $gender) {
                                                $selected = $student->sex == $gender ? 'selected' : '';
                                                echo "<option value=\"$gender\" $selected>$gender</option>";
                                            }
                                        @endphp
                                    </select>
                                    @error('profile_gender')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">NATIONALITY <span
                                            class="text-danger">*</span></small>
                                    <select name="profile_nationality"
                                        class="form-select form-select-sm border border-primary">
                                        <option disabled selected>SELECT NATIONALITY</option>
                                        @foreach ($nationalities as $nationality)
                                            <option value="{{ $nationality }}"
                                                {{ $student->nationality == $nationality ? 'selected' : '' }}>
                                                {{ $nationality }}</option>
                                        @endforeach
                                    </select>
                                    @error('profile_nationality')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">RELIGION <span
                                            class="text-danger">*</span></small>
                                    <select name="profile_religion"
                                        class="form-select form-select-sm border border-primary">
                                        <option disabled selected>SELECT RELIGION</option>
                                        @foreach ($religions as $religion)
                                            <option value="{{ $religion }}"
                                                {{ $student->religion == $religion ? 'selected' : '' }}>
                                                {{ $religion }}</option>
                                        @endforeach
                                    </select>
                                    @error('profile_religion')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">EMAIL ADDRESS<span
                                            class="text-danger">*</span></small>
                                    <input type="email" class="form-control form-control-sm border border-primary"
                                        name="profile_email" value="{{ $student->email }}">
                                    {{-- <small class="text-danger fw-bolder">Invalid email address.<span
                                            class="text-secondary">(try your email with @gmail, @yahoo, or @hotmail
                                            only.)</span></small> --}}
                                    @error('profile_email')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md ">
                                    <small class="fw-bolder text-muted">CONTACT NUMBER <span
                                            class="text-danger">*</span></small>
                                    <div class="row">
                                        <div class="col-md-2" style="padding: 0">
                                            <input type="text"
                                                class="form-control bg-light form-control-sm border border-primary"
                                                name="country_code" value="+63" readonly maxlength="3"
                                                placeholder="(UPDATE)">
                                        </div>
                                        <div class="col-md-9" style="padding: 0">
                                            <input type="text"
                                                class="form-control  form-control-sm border border-primary"
                                                name="profile_contact" value="{{ $student->contact_no }}"
                                                placeholder="(UPDATE)">
                                            <small>Example: <span class="text-secondary">(+639220890999)</span></small>

                                        </div>
                                    </div>
                                    @error('profile_contact')
                                        <span class="badge bg-danger mb-2">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="col-12 modal-footer mt-3">
                            <button type="submit" id="submit_edit_btn" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
