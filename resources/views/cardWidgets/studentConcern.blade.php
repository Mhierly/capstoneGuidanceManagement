<div class="card">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('Report Concern') }}</label>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>STATUS</th>
                    <th>DATE REQUEST</th>
                    <th>VICTIM NAME</th>
                    <th>ISSUE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->concernList as $item)
                    <tr>
                        <td>
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
                        </td>
                        <td>{{ $item->created_at->format('F d,Y') }}</td>
                        <td>{{ $item->victim_name }}</td>
                        <td>{{ $item->main_concern }}</td>
                        <td>
                            @if ($item->status === 1)
                                <a class="badge bg-success viewConcernModal" data-bs-toggle="modal"
                                    data-bs-target="#viewConcern" data-value="{{ $item->id }}"
                                    data-route="{{ route('admin.studentConcernStream', ['concern' => $item->id]) }}">
                                    VIEW
                                </a>
                                <a class="badge bg-primary approvedConcernModal" data-bs-toggle="modal"
                                    data-bs-target="#approvedConcern" data-value="{{ $item->id }}">APPROVED</a>
                                <a class="badge bg-danger remove-concern" data-student={{ $item->complainant_id }}
                                    data-concernid={{ $item->id }}>
                                    REMOVE
                                </a>
                            @elseif($item->status === 2)
                                {{--  <span class="badge bg-danger">CANCELLED <i class="bi bi-x-circle text-white"></i></span> --}}
                            @elseif($item->status === 3)
                                <a class="badge bg-primary completeConcern" data-value="{{ $item->id }}">
                                    COMPLETE SESSION
                                </a>
                            @elseif($item->status === 4)
                                <a class="badge bg-success viewConcernModal" data-bs-toggle="modal"
                                    data-bs-target="#viewConcern" data-value="{{ $item->id }}"
                                    data-route="{{ route('admin.studentConcernStream', ['concern' => $item->id]) }}">
                                    VIEW
                                </a>
                            @else
                                {{ $item->status }}
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="viewConcern" tabindex="-1" aria-labelledby="viewConcernLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="viewConcernLabel">STUDENT CONCERN</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" class="reportConcern"
                    style="width: 100%; height:1000px "></iframe>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="approvedConcern" tabindex="-1" aria-labelledby="approvedConcernLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-danger" id="concern_editorLabel">Take Action!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.student.concern.action') }}">
                    @csrf
                    <input type="text" name="concern_id" id="concern_id" hidden>
                    <div class="col-md-12">
                        <small class="fw-bolder text-muted">PROBLEM PRESENTED:</small>

                        <p id="concern"
                            class="fw-bold text-capitalize form-control form-control-sm border border-primary"></p>
                    </div>
                    <div class="col-md-12">
                        <label class="fw-bolder text-muted">Action Taken:</label>
                        <input type="text" id="actiontaken"
                            class="form-control form-control-sm border border-primary" name="actiontaken"
                            placeholder="Take action on this concern!" required>
                    </div>
                    <div class="col-md-12">
                        <label class="fw-bolder text-muted">Recommendation:</label>
                        <input type="text" id="rec" class="form-control form-control-sm border border-primary"
                            name="rec" placeholder="What are the guidance's will recommend in this concern?"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.approvedConcernModal', function() {
        var id = $(this).data('value');
        console.log(id)
        $('#concern_id').val(id)
        $.ajax({
            url: '{{ route('fetch.report.information') }}',
            type: 'GET',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response)
                if (response) {
                    $('#concern').html(response.main_concern);
                    $('#actiontaken').val(response.action_taken);
                    $('#rec').val(response.recommendation);
                } else {
                    alert('No data found. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    })
    $(document).on('click', '.viewConcernModal', function() {
        var id = $(this).data('value');
        var route = $(this).data('route')
        console.log(route)
        $(".reportConcern").attr("src", route);
    })
    $(document).on('click', '.completeConcern', function() {
        var concern_id = $(this).data('value');
        Swal.fire({
            title: 'Compelete Concern Report',
            text: 'Do you want to submit ',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0000FF',
            cancelButtonColor: '#ddd',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                $.ajax({
                    url: '{{ route('admin.student.concern.status') }}',
                    type: 'POST',
                    data: {
                        id: 4,
                        concern_id: concern_id,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error :
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

    function convertDate(date1) {
        const date = new Date(date1);
        const format = date.toISOString().replace('T', ' ').substring(0, 19);
        return format
        console.log(format);
        // Output: "2025-01-24 16:08:11"


    }
    $(document).on('click', '.remove-concern', function() {
        var id = $(this).data('id');
        var status_name = $(this).data('name');
        var concern_id = $(this).data('concernid');
        Swal.fire({
            title: 'Concern ',
            text: 'Cancel Request Concern',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0000FF',
            cancelButtonColor: '#ddd',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                $.ajax({
                    url: '{{ route('admin.student.concern.status') }}',
                    type: 'POST',
                    data: {
                        id: 2,
                        concern_id: concern_id,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            // table.ajax.reload();
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error :
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
</script>
