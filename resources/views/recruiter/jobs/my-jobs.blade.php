@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">My Jobs</li>
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
                                    <h3 class="fs-4 mb-1">My Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ route('recruiter.createJob') }}" class="btn btn-primary">Post a Job</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Full Status</th> <!-- New Full Status Column -->
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($jobs->isNotEmpty())
                                            @foreach ($jobs as $job)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $job->title }}</div>
                                                        <div class="info1">{{ $job->jobType->name }}/
                                                            @if ($job->location)
                                                                {{ $job->location->name }}
                                                            @else
                                                                No Location
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                                    <td>{{ $job->applications->count() }}</td>
                                                    <td>
                                                        @if ($job->status == 1)
                                                            <div class="job-status text-success text-capitalize">Active
                                                            </div>
                                                        @else
                                                            <div class="job-status text-capitalize text-danger">Blocked
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($job->isFull())
                                                            <div class="text-danger text-capitalize">Full</div>
                                                        @else
                                                            <div class="text-success text-capitalize">Not Full</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <button href="#" class="btn" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('jobDetail', $job->id) }}">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('recruiter.editJob', $job->id) }}">
                                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                                        Edit</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="removeMyJobs({{ $job->id }})">
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
                                                <td colspan="6">Job not found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $jobs->links() }}
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
        function removeMyJobs(jobId) {
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
                        url: "{{ route('recruiter.removeMyJobs') }}",
                        type: 'post',
                        data: {
                            jobId: jobId,
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
