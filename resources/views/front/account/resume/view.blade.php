@extends('front.layouts.app')

@section('main')
<div class="container-fluid p-0">
    <div class="row">
        <!-- Main content -->
        <div class="col-md-9">
            <!-- About -->
            <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
                <div class="w-100">
                    <h1 class="mb-0">
                        {{ $information['personal_info']['first_name'] ?? 'Empty' }}
                        <span class="text-primary">{{ $information['personal_info']['last_name'] ?? '' }}</span>
                    </h1>
                    <h3 class="mb-3">{{ $information['personal_info']['profile_title'] ?? '' }}</h3>
                    <div class="subheading mb-5">
                        <a href="mailto:{{ $information['contact_info']['email'] ?? '' }}">{{ $information['contact_info']['email'] ?? '' }}</a>
                        <a class="social-icon" href="{{ $information['contact_info']['linkedin_link'] ?? '' }}"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <p class="lead mb-5">{{ $information['personal_info']['about_me'] ?? '' }}</p>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Experience -->
            <section class="resume-section p-3 p-lg-5 d-flex justify-content-center" id="experience">
                <div class="w-100">
                    <h2 class="mb-5">Experience</h2>
                    @foreach ($information['experience_info'] ?? [] as $experience_info)
                        <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $experience_info['job_title'] ?? '' }}</h3>
                                <div class="subheading mb-3">{{ $experience_info['organization'] ?? '' }}</div>
                                <p>{{ $experience_info['job_description'] ?? '' }}</p>
                            </div>
                            <div class="flex-shrink-0"><span class="text-primary">{{ $experience_info['job_start_date'] ?? '' }} - {{ $experience_info['job_end_date'] ?? '' }}</span></div>
                        </div>
                    @endforeach
                </div>
            </section>
            <hr class="m-0" />
            <!-- Education -->
            <section class="resume-section p-3 p-lg-5 d-flex justify-content-center" id="education">
                <div class="w-100">
                    <h2 class="mb-5">Education</h2>
                    @foreach ($information['education_info'] ?? [] as $education_info)
                        <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $education_info['degree_title'] ?? '' }}</h3>
                                <div class="subheading mb-3">{{ $education_info['institute'] ?? '' }}</div>
                                <p>{{ $education_info['education_description'] ?? '' }}</p>
                            </div>
                            <div class="flex-shrink-0"><span class="text-primary">{{ $education_info['edu_start_date'] ?? '' }} - {{ $education_info['edu_end_date'] ?? '' }}</span></div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
