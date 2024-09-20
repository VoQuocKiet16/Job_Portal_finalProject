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

                    <div id="message">
                        @include('front.message')
                    </div> <!-- Add this to display dynamic notifications -->
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
                                                <p><i class="fas fa-map-marker-alt"></i> {{ $job->location->name }}</p>
                                            </div>
                                            <div class="location">
                                                <p><i class="fas fa-clock"></i> {{ $job->jobType->name }}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="">
                                        @if (Auth::check())
                                            <a class="heart_mark {{ $count ? 'green' : '' }}" href="javascript:void(0);"
                                                onclick="saveJob({{ $job->id }})">
                                                <i class="{{ $count ? 'fas fa-heart' : 'far fa-heart' }}"
                                                    aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('account.login') }}">
                                                <i class="{{ $count ? 'fas fa-heart' : 'far fa-heart' }}"
                                                    aria-hidden="true"></i>
                                            </a>
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
                                        class="btn btn-primary">Apply
                                    </a>
                                    <!-- Apply Job Modal -->
                                    <div class="modal fade" id="applyJobModal" tabindex="-1"
                                        aria-labelledby="applyJobModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content rounded-3"
                                                style="border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                                                <form id="applyJobForm" method="POST" action="{{ route('applyJob') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $job->id }}">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header"
                                                        style="background: linear-gradient(135deg, #FF7F50 0%, #FF4500 100%); border-top-left-radius: .3rem; border-top-right-radius: .3rem;">
                                                        <h5 class="modal-title text-white fw-bold text-uppercase text-start"
                                                            id="applyJobModalLabel">Apply for {{ $job->title }}</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <div class="modal-body p-4" style="background-color: #fff8f2;">
                                                        <!-- Select CV Option -->
                                                        <div class="form-group mb-4">
                                                            <label for="cvOption"
                                                                class="form-label fw-bold text-dark text-start"
                                                                style="font-size: 1.1rem; display: block;">Select CV to
                                                                apply</label>
                                                            <div class="form-check text-start">
                                                                <input class="form-check-input" type="radio"
                                                                    name="cvOption" id="useExisting" value="existing"
                                                                    checked>
                                                                <label class="form-check-label" for="useExisting">
                                                                    <i class="bi bi-folder-check"></i> Choose from my CV
                                                                    library
                                                                </label>
                                                            </div>
                                                            <div class="form-check mt-2 text-start">
                                                                <input class="form-check-input" type="radio"
                                                                    name="cvOption" id="uploadNew" value="upload">
                                                                <label class="form-check-label" for="uploadNew">
                                                                    <i class="bi bi-cloud-upload"></i> Upload new CV
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- CV Selection -->
                                                        <div class="form-group mb-4 text-start" id="resumeSelectSection">
                                                            <label for="resume_id"
                                                                class="form-label fw-bold text-dark text-start"
                                                                style="font-size: 1.1rem;">Select CV from your
                                                                account</label>
                                                            <select name="resume_id" id="resume_id"
                                                                class="form-select form-select-lg">
                                                                @foreach ($resumes as $resume)
                                                                    <option value="{{ $resume->id }}">
                                                                        {{ $resume->personalInformation->profile_title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Upload New CV -->
                                                        <div class="form-group mb-4 text-start" id="cvUploadSection"
                                                            style="display: none;">
                                                            <label for="cv_file"
                                                                class="form-label fw-bold text-dark text-start"
                                                                style="font-size: 1.1rem;">Upload CV (doc, docx,
                                                                pdf)</label>
                                                            <input type="file" name="cv_file" id="cv_file"
                                                                class="form-control form-control-lg"
                                                                accept=".doc,.docx,.pdf">
                                                        </div>

                                                        <!-- Cover Letter -->
                                                        <div class="form-group mb-4 text-start">
                                                            <label for="cover_letter"
                                                                class="form-label fw-bold text-dark text-start"
                                                                style="font-size: 1.1rem;">Cover Letter</label>
                                                            <textarea name="cover_letter" id="cover_letter" class="form-control text-start"
                                                                placeholder="Write your cover letter here..." style="resize: none; border-radius: .25rem; height: 300px;"></textarea>

                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer justify-content-between"
                                                        style="background-color: #ffefde;">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                            style="background-color: #6c757d; color: white; border-color: #6c757d;">Close</button>
                                                        <button type="submit" class="btn btn-primary px-5"
                                                            style="background: linear-gradient(135deg, #FF7F50 0%, #FF4500 100%); border: none;">
                                                            Application</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
            @if (Auth::check() && is_null(Auth::user()->email_verified_at))
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "You need to verify your email before apply jobs.",
                    confirmButtonText: 'Go to verification page'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('verification.notice') }}';
                    }
                });
                return;
            @endif

            $('#applyJobModal').modal('show');
            $('#applyJobForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('applyJob') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {

                            $('#applyJobModal').modal('hide');


                            $('#message').html(
                                '<div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert" style="padding: 15px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">' +
                                '<i class="bi bi-check-circle-fill me-2" style="font-size: 24px;"></i>' +
                                '<div>' + response.message + '</div>' +
                                '<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="outline: none;"></button>' +
                                '</div>'
                            );
                        } else {

                            $('#applyJobModal').modal('hide');


                            $('#message').html(
                                '<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert" style="padding: 15px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">' +
                                '<i class="bi bi-exclamation-circle-fill me-2" style="font-size: 24px;"></i>' +
                                '<div>' + response.message + '</div>' +
                                '<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="outline: none;"></button>' +
                                '</div>'
                            );
                        }


                        window.setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);
                    }
                });
            });
        }

        function saveJob(id) {
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
        $(document).ready(function() {
            $('input[name="cvOption"]').on('change', function() {
                if ($(this).val() == 'upload') {
                    $('#cvUploadSection').show();
                    $('#resumeSelectSection').hide();
                } else {
                    $('#cvUploadSection').hide();
                    $('#resumeSelectSection').show();
                }
            });
        });
    </script>
@endsection
