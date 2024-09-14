@extends('front.layouts.app')

@section('main')
    <style>
        .text-orange {
            color: #ff9511 !important;
        }

        .bg-orange {
            background-color: #ff9511 !important;
            color: #ffffff;
        }

        .btn-outline-primary-resume {
            border: 2px solid #FF9900;/
            color: #FF9900;
            padding: 10px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            border-radius: 0px;

        }


        .btn-outline-primary-resume:hover {
            /* background-color: #FF9900; */
            color: #000;
            border-color: #000;
        }


        .btn-outline-primary-resume:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <section class="section-5 bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 bg-white shadow-sm">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('recruiter.applications') }}">My Applicants</a>
                            </li>
                            <li class="breadcrumb-item active">Application Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3">
                    @include('recruiter.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold text-orange">Application Detail</h3>
                                <span
                                    class="badge bg-orange fs-6">{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</span>
                            </div>

                            <!-- Applicant Information -->
                            <div class="applicant-info mt-4">
                                <h5 class="text-dark fw-bold mb-3">Applicant Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name: </strong>{{ $application->user->name }}</p>
                                        <p><strong>Email: </strong>{{ $application->user->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Applied Date:
                                            </strong>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Information -->
                            <div class="job-info mt-4">
                                <h5 class="text-dark fw-bold mb-3">Job Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Title: </strong>{{ $application->job->title }}</p>
                                        <p><strong>Type: </strong>{{ $application->job->jobType->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Location: </strong>{{ $application->job->location->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Resume -->
                            <div class="resume-info mt-4">
                                <h5 class="text-dark fw-bold mb-3">Resume</h5>
                                @if ($application->resume_id)
                                    <a href="{{ route('viewResumeDetail', $application->resume_id) }}" target="_blank"
                                        class="btn btn-outline-primary-resume">
                                        View Resume from Library
                                    </a>
                                @elseif ($application->cv_file)
                                    <a href="{{ asset($application->cv_file) }}" target="_blank"
                                        class="btn btn-outline-primary-resume">
                                        View Uploaded Resume
                                    </a>
                                @else
                                    <p class="text-muted">No resume provided.</p>
                                @endif
                            </div>


                            <!-- Cover Letter -->
                            <div class="cover-letter-info mt-4">
                                <h5 class="text-dark fw-bold mb-3">Cover Letter</h5>
                                <p>{{ $application->cover_letter ? $application->cover_letter : 'No cover letter provided.' }}
                                </p>
                            </div>

                            <!-- Application Status -->
                            <div class="application-status mt-4">
                                <h5 class="text-dark fw-bold mb-3">Application Status</h5>
                                <span
                                    class="badge 
                                {{ $application->status === 1 ? 'bg-success' : ($application->status === 0 ? 'bg-danger' : 'bg-warning') }}">
                                    {{ $application->status === 1 ? 'Approved' : ($application->status === 0 ? 'Rejected' : 'Pending') }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="action-buttons mt-4 d-flex gap-3">
                                <form method="POST"
                                    action="{{ route('recruiter.applications.approve', $application->id) }}">
                                    @csrf
                                    <button class="btn btn-success rounded-pill"
                                        {{ $application->status === 1 ? 'disabled' : '' }}>Approve</button>
                                </form>

                                <form method="POST"
                                    action="{{ route('recruiter.applications.reject', $application->id) }}">
                                    @csrf
                                    <button class="btn btn-danger rounded-pill"
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
