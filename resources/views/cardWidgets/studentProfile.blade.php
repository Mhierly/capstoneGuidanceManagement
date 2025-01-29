<div class="card">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('Personal Information') }}</label>
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
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('Educational Background') }}</label>
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
                <p class="form-control form-control-sm border border-primary">
                    {{ $student->yearLevel()->grade_level }}
                </p>
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
                    {{ $student->adviser()->adviser_name }}
                </p>
            </div>
        </div>
    </div>
</div>
