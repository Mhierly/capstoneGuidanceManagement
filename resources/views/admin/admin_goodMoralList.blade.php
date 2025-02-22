@extends('layouts.app')
@section('title-page', 'Good Moral')
@section('content')
    <div class="student-container shadow-lg">
        <div>
            <div>
                <h3>List of Good Moral Request</h3>
            </div>
            <table id="goodMoralRequest" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Student Name</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('layouts.student_profile')
    @include('layouts.loading')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#goodMoralRequest').DataTable({
                processing: true,
                serverSide: true,
                scrollY: '50vh',
                ajax: {
                    method: 'get',
                    url: "{{ route('fetch.counselor.gm.requests') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'gm_status',
                        name: 'gm_status'
                    },
                    {
                        data: 'reason',
                        name: 'reason'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
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
                    }
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

            $(document).on('click', '#update_status_btn', function() {
                var id = $(this).data('id');
                var status_name = $(this).data('name');
                var gm_id = $(this).data('gm');

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
                            url: '{{ route('admin.student.goodmoral.status') }}',
                            type: 'POST',
                            data: {
                                id: id,
                                gm_id: gm_id,
                                _token: $('meta[name="csrf-token"]').attr('content'),
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

            $(document).on('click', '#approve_status_btn', async function() {
                var id = $(this).data('id');
                var existing_notes = $(this).data('notes');
                var gm_id = $(this).data('gm');

                const {
                    value: notes
                } = await Swal.fire({
                    input: "textarea",
                    inputLabel: "Notes",
                    inputValue: existing_notes ? existing_notes : "",
                    inputPlaceholder: "Type your message here...",
                    inputAttributes: {
                        "aria-label": "Type your message here"
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Confirm'
                });
                if (notes) {
                    // Swal.fire(text);
                    showLoading();
                    $.ajax({
                        url: '{{ route('admin.student.goodmoral.approve') }}',
                        type: 'POST',
                        data: {
                            gm_id: gm_id,
                            notes: notes,
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
                            var errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                                xhr.responseJSON.error :
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

            $('#student_info_modal').on('show.bs.modal', function(event) {
                var id = $(event.relatedTarget).data('id');

                var url_img = "{{ route('student.image.v2', ['id' => ':id']) }}".replace(':id', id);
                $.get(url_img, function(response) {
                    console.log(response)
                    $('#student_profile_img').attr('src', response);

                    $('#student_profile_img').on('error', function() {
                        console.error('Image not found at ' + response);
                        $(this).attr('src', "{{ asset('img/default.jpg') }}");
                    });
                })

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

            $(document).on('click', '#download_gm_form', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Download',
                    text: 'Download student good moral form.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#rrr',
                    cancelButtonColor: '#ddd',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        var url =
                            `{{ route('admin.student.goodmoral.download') }}?id=${id}&_token=${token}`;
                        window.open(url, '_blank');
                    }
                });
            });

            $(document).on('click', '#archive_gm_item', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Archive?',
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
                            url: '{{ route('admin.student.goodmoral.archive') }}',
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
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('error_update'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error_update') }}'
                });
            @elseif (session('status_update'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('status_update') }}'
                });
            @elseif (session('status_no_update'))
                Swal.fire({
                    icon: 'info',
                    title: 'No Changes!',
                    text: '{{ session('status_no_update') }}'
                });
            @endif
        })
    </script>
@endsection
