@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('recruiter.applications') }}">My Applicants</a>
                            </li>
                            <li class="breadcrumb-item active">Application Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('recruiter.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Application Detail</h3>
                                </div>
                            </div>


                            <div class="mt-4">
                                <h5 class="fw-bold">Applicant Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Name:</strong> {{ $application->user->name }}</li>
                                    <li><strong>Email:</strong> {{ $application->user->email }}</li>
                                    <li><strong>Applied Date:</strong>
                                        {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</li>
                                </ul>
                            </div>


                            <div class="mt-4">
                                <h5 class="fw-bold">Job Information</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Title:</strong> {{ $application->job->title }}</li>
                                    <li><strong>Type:</strong> {{ $application->job->jobType->name }}</li>
                                    <li><strong>Location:</strong> {{ $application->job->location->name }}</li>
                                </ul>
                            </div>

                            <!-- Resume -->
                            <div class="mt-4">
                                <h5 class="fw-bold">Resume</h5>
                                @if ($application->resume_id)
                                    @if ($application->resume_id)
                                        <a href="{{ route('viewResumeDetail', $application->resume_id) }}" target="_blank"
                                            class="btn btn-outline-primary">
                                            View Resume from Library
                                        </a>
                                    @else
                                        <p>No resume available.</p>
                                    @endif
                                @elseif ($application->cv_file)
                                    <a href="{{ asset($application->cv_file) }}" target="_blank"
                                        class="btn btn-outline-primary">
                                        View Uploaded Resume
                                    </a>
                                @else
                                    <p>No resume provided.</p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <h5 class="fw-bold">Cover Letter</h5>
                                <p>{{ $application->cover_letter ? $application->cover_letter : 'No cover letter provided.' }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <h5 class="fw-bold">Application Status</h5>
                                <span
                                    class="badge 
                                    {{ $application->status === 1 ? 'bg-success' : ($application->status === 0 ? 'bg-danger' : 'bg-warning') }}">
                                    {{ $application->status === 1 ? 'Approved' : ($application->status === 0 ? 'Rejected' : 'Pending') }}
                                </span>
                            </div>


                            <div class="mt-4 d-flex gap-2">
                                <h5 class="fw-bold">Change Status: </h5>
                                <form method="POST"
                                    action="{{ route('recruiter.applications.approve', $application->id) }}">
                                    @csrf
                                    <button class="btn btn-success"
                                        {{ $application->status === 1 ? 'disabled' : '' }}>Approve</button>
                                </form>

                                <form method="POST"
                                    action="{{ route('recruiter.applications.reject', $application->id) }}">
                                    @csrf
                                    <button class="btn btn-danger"
                                        {{ $application->status === 0 ? 'disabled' : '' }}>Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
