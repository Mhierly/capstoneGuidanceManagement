<div class="card">
    <div class="card-header">
        <label for="" class="fw-bolder text-primary h4">{{ strtoupper('recent Drop Request') }}</label>
        <button type="button" class="btn btn-secondary btn-sm float-end" data-bs-toggle="modal"
            data-bs-target="#modalRequestForm">
            CREATE REQUEST
        </button>
    </div>
    <div class="card-body ">
        <div class="table-container">
            <table class="table table-hover table-bordered table-striped" style=" overflow-x: auto; width:120%;">
                <thead>
                    <tr>
                        <th>STATUS</th>
                        <th style="width: 25%">REQUESTED DATE</th>
                        <th style="width: 25%">EXPECTED DATE OF RETURN</th>
                        <th style="width: 25%">NOTES</th>
                        <th style="width: 70%">REASON</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dropList as $item)
                        <tr>
                            <td>

                                @if ($item->status === 1)
                                    <span class="badge bg-secondary">PENDING <i
                                            class="bi bi-hourglass-bottom text-white"></i></span>
                                @elseif($item->status === 2)
                                    <span class="badge bg-danger">CANCELLED <i
                                            class="bi bi-x-circle text-white"></i></span>
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
                            <td>{{ $item->created_at->format('F d, Y h:i a') }}</td>
                            <td>
                                @if ($item->status != 1 && $item->status != 2)
                                    <span class="badge bg-success">
                                        {{ $item->request_date }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">PENDING <i
                                            class="bi bi-hourglass-bottom text-white"></i></span>
                                @endif
                            </td>
                            <td>{{ $item->notes }}</td>
                            <td>{{ $item->reason }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <a class="badge bg-danger cancel_request" data-value="{{ $item->drop_request_id }}">
                                        <i class="bi bi-x-circle" style="color: white;"> CANCEL <br> REQUEST </i>
                                    </a>
                                @elseif($item->status === 4 || $item->status === 3)
                                    <a class="badge bg-primary dropDetails" data-bs-toggle="modal"
                                        data-bs-target="#dropDetails" data-value="{{ $item->drop_request_id }}">
                                        VIEW
                                    </a>
                                @endif


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No Request</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Add Form Modal --}}
<div class="modal fade" id="modalRequestForm" tabindex="-1" aria-labelledby="modalRequestFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5 fw-bolder text-primary" id="modalRequestFormLabel">
                    {{ strtoupper('Request for Dropping') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.request.drop') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="requestDate" class="text-muted">Request Date: (Please specify the date of your
                            dropping.)</label>
                        <input type="date" class="form-control border border-primary" id="requestDate"
                            name="requestDate" required>
                        @error('requestDate')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="reason">Reason: (Please justify your reason.)</label>
                        <textarea class="form-control  border border-primary" id="reason" name="reason" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Submit Request</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dropDetails" tabindex="-1" aria-labelledby="dropDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5 fw-bolder text-primary" id="dropDetailsLabel">DROP DETAILS
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md">
                        <small class="fw-bolder text-muted">REQUEST DATE</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary request-date"></label>
                    </div>
                    <div class="col-md">
                        <small class="fw-bolder text-muted">EXPECTED DATE OF RETURN</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary return-date"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <small class="fw-bolder text-muted">REASON</small>
                        <label for="" class="form-control form-control-sm border border-primary reason"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <small class="fw-bolder text-muted">CONCELOR</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary counselor"></label>
                    </div>
                    <div class="col-md">
                        <small class="fw-bolder text-muted">NOTES</small>
                        <label for=""
                            class="form-control form-control-sm border border-primary notes"></label>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.dropDetails', function() {
        var id = $(this).data('value');
        $('.appointmentInput').val(id);
        $.get('/user/drop-details/details?id=' + id, function(response) {
            console.log(response)
            if (response.dropDetails) {
                let dropDetails = response.dropDetails
                $('.return-date').text(dropDetails.returnDate)
                $('.request-date').text(dropDetails.requestDate)
                $('.reason').text(dropDetails.reason)
                $('.counselor').text(dropDetails.counselor)
                $('.notes').text(dropDetails.notes)

            }
        })
    })
</script>
