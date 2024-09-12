@extends('front.layouts.app')

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left"
                                        aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8"> <!-- Left Column -->
                    @include('front.message')
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $job->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p><i class="fa fa-map-marker"></i> {{ $job->location->name }}</p>
                                            </div>
                                            <div class="location">
                                                <p><i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="">
                                        @if (Auth::check())
                                            <a class="heart_mark {{ $count ? 'green' : '' }}" href="javascript:void(0);"
                                                onclick="saveJob({{ $job->id }})">
                                                <i class="fa {{ $count ? 'fa-heart' : 'fa-heart-o' }}"
                                                    aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('account.login') }}"> <i class="fa {{ $count ? 'fa-heart' : 'fa-heart-o' }}"
                                                aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                {!! nl2br($job->description) !!}
                            </div>
                            @if (!empty($job->responsibility))
                                <div class="single_wrap">
                                    <h4>Responsibility</h4>
                                    {!! nl2br($job->responsibility) !!}
                                </div>
                            @endif
                            @if (!empty($job->qualifications))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    {!! nl2br($job->qualifications) !!}
                                </div>
                            @endif
                            @if (!empty($job->benefits))
                                <div class="single_wrap">
                                    <h4>Benefits</h4>
                                    {!! nl2br($job->benefits) !!}
                                </div>
                            @endif
                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                @if (Auth::check())
                                    <a href="javascript:void(0);" onclick="applyJob({{ $job->id }})"
                                        class="btn btn-primary">Apply</a>
                                @else
                                    <a href="{{ route('account.login') }}" class="btn btn-primary">Login to Apply</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 mt-4">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    <div class="jobs_conetent">
                                        <h4>Related Jobs</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg position-relative">
                            @if ($relatedJobs->isNotEmpty())
                                <div id="relatedJobsCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($relatedJobs->chunk(2) as $index => $relatedJobsChunk)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <div class="row">
                                                    @foreach ($relatedJobsChunk as $relatedJob)
                                                        <div class="col-md-6">
                                                            <div class="card shadow-sm">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $relatedJob->title }}</h5>
                                                                    <p class="card-text">
                                                                        <i class="fa fa-map-marker"></i>
                                                                        {{ $relatedJob->location->name }}<br>
                                                                        <i class="fa fa-clock-o"></i>
                                                                        {{ $relatedJob->jobType->name }}
                                                                    </p>
                                                                    <a href="{{ route('jobDetail', $relatedJob->id) }}"
                                                                        class="btn btn-primary d-flex justify-content-center">View
                                                                        Job</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <a class="previous round" onclick="$('#relatedJobsCarousel').carousel('prev')">&#8249;</a>
                                <a class="next round" onclick="$('#relatedJobsCarousel').carousel('next')">&#8250;</a>
                            @else
                                <p>No related jobs found.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4"> <!-- Right Column -->
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summary</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on:
                                        <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span>
                                    </li>
                                    <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                    @if (!empty($job->salary))
                                        <li>Salary: <span>{{ $job->salary }}</span></li>
                                    @endif
                                    <li>Location: <span>{{ $job->location->name }}</span></li>
                                    <li>Job Nature: <span>{{ $job->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                    @if (!empty($job->company_location))
                                        <li>Location: <span>{{ $job->company_location }}</span></li>
                                    @endif
                                    @if (!empty($job->company_website))
                                        <li>Website: <span><a
                                                    href="{{ $job->company_website }}">{{ $job->company_website }}</a></span>
                                        </li>
                                    @endif
                                </ul>
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
        function applyJob(id) {
            if (confirm("Are you sure you want to apply on this job?")) {
                $.ajax({
                    url: '{{ route('applyJob') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ url()->current() }}";
                        // window.location.href = "{{ url('jobs/detail') }}/" + id;
                    }
                });
            }
        }

        function saveJob(id) {
            if (confirm("Are you sure you want to save this job?")) {
                $.ajax({
                    url: '{{ route('saveJob') }}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('.heart_mark').toggleClass('green');
                        window.location.href = "{{ url()->current() }}";
                    }
                });
            }
        }
    </script>
@endsection
