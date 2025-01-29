@extends('layouts.app')
@section('title-page', 'Profile')
@section('content')
    <div class="container">
        <h1 class="text-primary fw-bolder">STUDENT INFORMATION</h1>
        <div class="row">
            <div class="col-md-4">
                @if ($student)
                    <div class="card mb-2">
                        <div class=" no-gutters">
                            <div class="text-center">
                                <img src="{{ $student->studentProfile() }}" class="avatar-130 rounded" style="width:50%"
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <label for="" class="fw-bolder text-secondary">
                                SETTING <i class="bi bi-gear"></i>
                            </label>
                            <a {{-- data-bs-toggle="modal" data-bs-target="#edit_profile" --}} href="{{ route('user.viewProfileV2', ['editor' => 'profile']) }}"
                                class="btn btn-primary btn-sm mt-2 w-100">UPDATE STUDENT
                                INFORMATION</a>
                            <a href="{{ route('user.viewProfileV2', ['editor' => 'educational-background']) }}"
                                class="btn btn-primary btn-sm mt-2 w-100">UPDATE EDUCATION
                                BACKGROUND</a>
                        </div>
                    </div>
                @else
                @endif
            </div>
            <div class="col-md">
                @if (session('status_update'))
                    <div class="alert alert-success">
                        {{ session('status_update') }}
                    </div>
                @endif
                @if (session('error_update'))
                    <div class="alert alert-danger">
                        {{ session('error_update') }}
                    </div>
                @endif
                @if (session('status_no_update'))
                    <div class="alert alert-secondary">
                        {{ session('status_no_update') }}
                    </div>
                @endif
                @if (request()->input('editor') == 'profile')
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('user.viewProfileV2') }}"
                                class="btn btn-sm btn-outline-danger float-end">CANCEL</a>
                            <label for="" class="fw-bolder text-primary h4">UPDATE PERSONAL INFORMATION</label>
                        </div>
                        <div class="card-body">
                            <form id="edit_form" class="row g-3" action="{{ route('student.profile.editor.v2') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-form">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-2">
                                            <img src="{{ $student->studentProfile() }}" alt="Student Image" class=""
                                                width="110" height="110" style="object-fit: cover;">
                                            <input type="file" class="form-control form-control-sm border border-primary"
                                                name="student_profile" id="img">
                                            @error('student_profile')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                            <div id="file-error" class="text-danger mt-2" style="display:none;">Please
                                                select a
                                                valid
                                                image file (jpg, jpeg, png, gif).</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">LAST NAME <span
                                                    class="text-danger">*</span></small>
                                            <input type="text" class="form-control form-control-sm border border-primary"
                                                name="last_name" value="{{ $student->lastname }}">
                                            @error('last_name')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">FIRST NAME <span
                                                    class="text-danger">*</span></small>
                                            <input type="text" class="form-control form-control-sm border border-primary"
                                                name="first_name" value="{{ $student->firstname }}">
                                            @error('first_name')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">MIDDLE NAME </small>
                                            <input type="text" class="form-control form-control-sm border border-primary"
                                                name="middle_name" value="{{ $student->middlename }}">
                                        </div>
                                        <div class="col-md-2 ">
                                            <small class="fw-bolder text-muted">SUFFIX </small>
                                            <input type="text" class="form-control form-control-sm border border-primary"
                                                name="suffix" value="{{ $student->suffix }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">BIRTH DATE <span
                                                    class="text-danger">*</span></small>
                                            <input type="date" class="form-control form-control-sm border border-primary"
                                                name="birthdate" value="{{ $student->birthday }}">
                                            @error('birthdate')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">GENDER <span
                                                    class="text-danger">*</span></small>
                                            <select id="gender" name="gender"
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
                                            @error('gender')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">NATIONALITY <span
                                                    class="text-danger">*</span></small>
                                            <select name="nationality"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled selected>SELECT NATIONALITY</option>
                                                @foreach ($nationalities as $nationality)
                                                    <option value="{{ $nationality }}"
                                                        {{ $student->nationality == $nationality ? 'selected' : '' }}>
                                                        {{ $nationality }}</option>
                                                @endforeach
                                            </select>
                                            @error('nationality')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <small class="fw-bolder text-muted">RELIGION <span
                                                    class="text-danger">*</span></small>
                                            <select name="religion"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled selected>SELECT RELIGION</option>
                                                @foreach ($religions as $religion)
                                                    <option value="{{ $religion }}"
                                                        {{ $student->religion == $religion ? 'selected' : '' }}>
                                                        {{ $religion }}</option>
                                                @endforeach
                                            </select>
                                            @error('religion')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md ">
                                            <small class="fw-bolder text-muted">EMAIL ADDRESS<span
                                                    class="text-danger">*</span></small>
                                            <input type="email"
                                                class="form-control form-control-sm border border-primary" name="email"
                                                value="{{ $student->email }}">
                                            @error('email')
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
                                                        name="contact" value="{{ $student->contact_no }}"
                                                        placeholder="(UPDATE)">
                                                    <small>Example: <span
                                                            class="text-secondary">(+639220890999)</span></small>

                                                </div>
                                            </div>
                                            @error('contact')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">
                                        <label for="" class="fw-bolder text-primary">| ADDRESS</label>
                                        <div class="col-md-4 mb-3">
                                            <small class="fw-bolder text-muted">PROVINCE<span
                                                    class="text-danger">*</span></small>

                                            <select id="province" name="province"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled>Select Province</option>
                                                @foreach ($province as $item)
                                                    <option value="{{ $item->province_code }}"
                                                        {{ (int) $student->province === (int) $item->province_code ? 'selected' : '' }}>
                                                        {{ $item->province_description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('province')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <small class="fw-bolder text-muted">MUNICIPALITY<span
                                                    class="text-danger">*</span></small>
                                            <select id="municipality" name="municipality"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled>Select</option>
                                            </select>
                                            @error('municipality')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <small class="fw-bolder text-muted">BARANGAY<span
                                                    class="text-danger">*</span></small>
                                            <select id="baranggay" name="baranggay"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled>Select</option>
                                            </select>
                                            @error('baranggay')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <small class="fw-bolder text-muted">STREET<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary" id="street"
                                                name="street" placeholder="(UPDATE)"
                                                value="{{ $student->house_no_street }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="" class="fw-bolder text-primary">| PARENT'S
                                            INFORMATION</label>
                                        <div class="col-md-6">
                                            <small class="fw-bolder text-muted">FATHER'S NAME<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary" name="father"
                                                value="{{ $student->father }}">
                                            @error('father')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <small class="fw-bolder text-muted">MOTHER'S NAME<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary" name="mother"
                                                value="{{ $student->mother }}">
                                            @error('mother')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 ">
                                            <small class="fw-bolder text-muted">FATHER OCCUPATION <span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary"
                                                name="father_occupation" value="{{ $student->father_occupation }}">
                                            @error('mother')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 ">
                                            <small class="fw-bolder text-muted">MOTHER OCCUPATION <span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary"
                                                name="mother_occupation" value="{{ $student->mother_occupation }}">
                                            @error('mother')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="fw-bolder text-muted">CURENLTY LIVING WITH<span
                                                    class="text-danger">*</span></small>
                                            <select id="living_with" name="living_with"
                                                class="form-select form-select-sm border border-primary">
                                                <option disabled selected>SELECT GENDER</option>
                                                <option value="Father"
                                                    {{ $student->living_with == 'Father' ? 'selected' : '' }}>Father
                                                </option>
                                                <option value="Mother"
                                                    {{ $student->living_with == 'Mother' ? 'selected' : '' }}>Mother
                                                </option>
                                                <option value="Other"
                                                    {{ $student->living_with == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                            @error('living_with')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 ">
                                            <small class="fw-bolder text-muted">NO. OF SIBLINGS<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary"
                                                name="no_of_siblings" value="{{ $student->no_of_siblings }}">
                                            @error('no_of_siblings')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 ">
                                            <small class="fw-bolder text-muted">SIBLINGS POSITION<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary" name="position"
                                                value="{{ $student->position }}" min="1"
                                                max="{{ $student->no_of_siblings }}">
                                            @error('position')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 ">
                                            <small class="fw-bolder text-muted">EMERGENCY CONTACT<span
                                                    class="text-danger">*</span></small>
                                            <input type="text"
                                                class="form-control form-control-sm border border-primary"
                                                name="emergency_contact" value="{{ $student->emergency_contact }}">
                                            @error('emergency_contact')
                                                <span class="badge bg-danger mb-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 modal-footer mt-3">
                                    <button type="submit" id="submit_edit_btn" class="btn btn-success">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif(request()->input('editor') == 'educational-background')
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('user.viewProfileV2') }}"
                                class="btn btn-sm btn-outline-danger float-end">CANCEL</a>
                            <label for="" class="fw-bolder text-primary h4">UPDATE EDUCATIONAL BACKGROUND</label>
                        </div>
                        <div class="card-body">
                            <form id="edit_profile2_form" class="row g-3"
                                action="{{ route('student.profile.editor.educational') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-12">
                                    <small class="text-muted fw-bolder">
                                        LEARNER REFERENCE NUMBER <small class="text-danger">(12-digit number)</small> <span
                                            class="text-danger">*</span>
                                    </small>
                                    <input type="text" id="lrn"
                                        class="form-control form-control-sm border border-primary" name="lrn"
                                        value="{{ $student->lrn }}" pattern="\d{12}"
                                        title="Please enter a 12-digit number" maxlength="12" oninput="validateLRN(this)"
                                        placeholder="(Need to update)" required>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted fw-bolder">
                                        ELEMENTARY SCHOOL GRADUATE <span class="text-danger">*</span>
                                    </small>
                                    <input type="text" id="elem_school"
                                        class="form-control form-control-sm border border-primary" name="elem_school"
                                        value="{{ $student->elem_school }}" placeholder="(Need to update)">
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted fw-bolder">
                                        STUDENT GENERAL AVERAGE <span class="text-danger">*</span>
                                    </small>
                                    <input type="number" min="50" max="100" id="gen_average"
                                        name="gen_average" value="{{ $student->gen_average }}"
                                        class="form-control form-control-sm border border-primary">
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted fw-bolder">STUDENT CURRENT GRADE <span
                                            class="text-danger">*</span></small>
                                    <select id="current_grade_options"
                                        class="form-select form-select-sm border border-primary"
                                        name="current_grade_options">
                                        <option disabled selected>(UPDATE)</option>
                                        @forelse ($grades as $level)
                                            <option value="{{ $level->id }}"
                                                {{ $student->current_grade == $level->id ? 'selected' : '' }}>
                                                {{ $level->grade_level }}</option>
                                        @empty
                                            <option value="">No Data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted fw-bolder">
                                        STUDENT CURRENT SECTION <span class="text-danger">*</span>
                                    </small>
                                    <select id="current_section_options"
                                        class="form-select form-select-sm border border-primary"
                                        name="current_section_options">
                                        <option disabled selected>(UPDATE)</option>
                                        @forelse ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ $student->current_section == $section->id ? 'selected' : '' }}>
                                                {{ $section->section_name }}</option>
                                        @empty
                                            <option value="">No Data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted fw-bolder">
                                        ADVISER <span class="text-danger">*</span>
                                    </small>
                                    <select id="adviser" class="form-select form-select-sm border border-primary"
                                        name="adviser">
                                        <option disabled selected>(UPDATE)</option>
                                        @php
                                            foreach ($advisers as $adviser) {
                                                $selected = $student->adviser == $adviser->id ? 'selected' : '';
                                                echo "<option value=\"$adviser->id\" $selected>$adviser->adviser_name</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-12 modal-footer mt-3">
                                    <button type="submit" id="submit_edit_btn2" class="btn btn-success">Save
                                        Changes</button>
                                </div>

                            </form>
                        </div>
                    </div>
                @else
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
                                    <div class="form-group col-md-4">
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
                    <div class="card mt-3">
                        <div class="card-header">
                            <label for=""
                                class="fw-bolder text-primary h4">{{ strtoupper('Educational Background') }}</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('Elementary School Graduate') }}
                                    </small>
                                    <p class="form-control form-control-sm border border-primary">
                                        @if ($student->elem_school)
                                            {{ $student->elem_school }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('School Address') }}
                                    </small>
                                    <p class="form-control form-control-sm border border-primary">
                                        BNHS-SINIPIT, BONGABON, N.E
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('General Average') }}
                                    </small>
                                    <p class="form-control form-control-sm border border-primary">
                                        @if ($student->gen_average)
                                            {{ $student->gen_average }}
                                        @else
                                            <span class="text-danger">Need to update</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('Last Grade Level Completed') }}
                                    </small>
                                    @if ($student->yearLevel())
                                        <p class="form-control form-control-sm border border-primary">
                                            {{ $student->yearLevel()->grade_level }}
                                        </p>
                                    @endif

                                </div>
                                <div class="col-md-6">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('School ID') }}
                                    </small>
                                    <p class="form-control form-control-sm border border-primary">
                                        @if ($student->school_id)
                                            {{ $student->school_id }}
                                        @else
                                            {{ $current_year }}-xxxx
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <small class="fw-bolder text-secondary">
                                        {{ strtoupper('Adviser') }}
                                    </small>
                                    <p class="form-control form-control-sm border border-primary">
                                        @if ($student->adviser())
                                            {{ $student->adviser()->adviser_name }}
                                        @endif

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const province = '{{ $student->province }}';
            setMunicipality(province)
            const municipality = '{{ $student->municipality }}';
            // setMunicipality(province)
            setBarangay(province, municipality)
            $('#province').on('change', function() {
                let value = $('#province').val();
                setMunicipality(value)
                console.log(value)
            });
            $('#municipality').on('change', function() {
                const provinceCode = $('#province').val();
                const cityCode = $('#municipality').val();
                setBarangay(provinceCode, cityCode)
            });
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
        });

        function setMunicipality(provinceCode) {
            const cityDropdown = $('#municipality');
            const selectedMunicipality = '{{ $student->municipality }}';

            $.ajax({
                type: 'GET',
                url: `{{ route('fetch.user.location.cities', ':province_code') }}`.replace(
                    ':province_code', provinceCode),
                success: (cities) => {
                    // Clear and populate the city dropdown
                    cityDropdown.html(cities.map(city => {
                        const isSelected = city.city_municipality_code ===
                            selectedMunicipality ? 'selected' : '';
                        return `<option value="${city.city_municipality_code}" ${isSelected}>${city.city_municipality_description}</option>`;
                    }).join(''));
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching cities:', xhr.responseText);
                }
            });

        }

        function setBarangay(provinceCode, cityCode) {

            console.log(cityCode)
            const barangayDropdown = $('#baranggay');
            const selectedBarangay = '{{ $student->baranggay }}';

            // Construct the URL with province and city codes
            const url = `{{ route('fetch.user.location.barangays', [':province_code', ':city_code']) }}`
                .replace(':province_code', provinceCode)
                .replace(':city_code', cityCode);

            $.ajax({
                type: 'GET',
                url: url,
                success: (barangays) => {
                    // Clear and populate the barangay dropdown
                    barangayDropdown.html(barangays.map(barangay => {
                        const isSelected = barangay.barangay_code === selectedBarangay ?
                            'selected' : '';
                        return `<option value="${barangay.barangay_code}" ${isSelected}>${barangay.barangay_description}</option>`;
                    }).join(''));
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching barangays:', xhr.responseText);
                }
            });

        }
    </script>
@endsection
