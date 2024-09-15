@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">My Applicants</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('recruiter.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Applicants</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Applicant Name</th>
                                            <th scope="col">Job Title</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $application->user->name }}</td>
                                                    <td>{{ $application->job->title }}</td>
                                                    <td>
                                                        @if ($application->status === 1)
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif($application->status === 0)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form method="POST"
                                                            action="{{ route('recruiter.applications.approve', $application->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            <button class="btn btn-success"
                                                                {{ $application->status === 1 ? 'disabled' : '' }}>Approve</button>
                                                        </form>

                                                        <form method="POST"
                                                            action="{{ route('recruiter.applications.reject', $application->id) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            <button class="btn btn-danger"
                                                                {{ $application->status === 0 ? 'disabled' : '' }}>Reject</button>
                                                        </form>
                                                        <div class="action-dots float-end">
                                                            <button href="#" class="btn" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('recruiter.applications.detail', $application->id) }}">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="removeMyApplicants({{ $application->id }})">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        Remove</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">No applications found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $applications->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        @if (session('swal_message'))
            Swal.fire({
                title: "Job is Full!",
                text: "{{ session('swal_message') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        @endif
        function removeMyApplicants(applicantId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, remove it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('recruiter.removeMyApplicants') }}",
                        type: 'post',
                        data: {
                            applicantId: applicantId,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                title: "Remove!",
                                text: "Your job has been removed.",
                                icon: "success"
                            }).then(() => {
                                window.location.href = "{{ url()->current() }}";
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error!",
                                text: "Something went wrong, please try again.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }
        
    </script>
@endsection
