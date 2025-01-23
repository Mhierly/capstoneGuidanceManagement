@extends('layouts.app')
@section('title-page', 'Request Forms')
@section('content')
    <div class="container">
        <h1 class="text-primary fw-bolder">REQUEST FORMS</h1>
        <div class="row">
            <div class="col-lg-4 col-md-12 ">
                <div class="card mb-3">
                    <div class="card-body">
                        <small class="fw-bolder text-muted">
                            LIST OF REQUEST FORMS
                        </small>
                        <a href="{{ route('user.viewForm', ['form' => 'appointment']) }}"
                            class="btn {{ request()->input('form') == 'appointment' ? ' btn-primary' : 'btn-outline-primary' }} btn-sm mt-2 w-100">
                            APPOINTMENT
                        </a>
                        <a href="{{ route('user.viewFormDrop') }}"
                            class="btn {{ request()->input('form') == 'dropping-form' ? ' btn-primary' : 'btn-outline-primary' }} btn-sm mt-2 w-100">
                            DROPPING FORM
                        </a>
                        <a href="{{ route('user.viewFormMoral') }}"
                            class="btn {{ request()->input('form') == 'good-moral' ? ' btn-primary' : 'btn-outline-primary' }} btn-sm mt-2 w-100">
                            GOOD MORAL CERTIFICATE
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md">
                @if (request()->input('form') == 'appointment')
                    @include('user.request_forms.component.appointment')
                @elseif(request()->input('form') == 'good-moral')
                @else
                    @include('user.request_forms.component.appointment')
                @endif

            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.cancel_request', function() {
            var id = $(this).data('value');
            Swal.fire({
                title: 'Cancel Request?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('user.request.cancel') }}',
                        type: 'POST',
                        data: {
                            id: id,
                            request_type: 2,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Request cancelled!',
                                text: response,
                            }).then(() => {
                                // Reload the DataTable
                                window.location.reload(true);
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
                            window.location.reload(true);
                        }
                    });
                }
            });
        })
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
    </script>
@endsection
