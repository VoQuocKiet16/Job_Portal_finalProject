<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

@extends('front.layouts.app')

@section('main')
<div class="container-fluid p-0">
    <div class="row no-gutters">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar text-white p-4" id="sidebar">
            <div class="text-center mb-4">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">
                    <span class="d-none d-lg-block">
                        @if (Auth::user()->image != '')
                            <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar"
                                class="rounded-circle img-fluid avatar" style="width: 150px;">
                        @else
                            <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar"
                                class="rounded-circle img-fluid avatar" style="width: 150px;">
                        @endif
                    </span>
                </a>
            </div>

            <div class="social-icons mt-4 text-secondary">
                @if (!empty($information['contact_info']['linkedin_link']))
                    <a href="{{ $information['contact_info']['linkedin_link'] }}" class="text-black mx-2" target="_blank">
                        <i class="fa fa-link"></i> {{ $information['contact_info']['linkedin_link'] }}
                    </a>
                @else
                    <p>No LinkedIn profile available</p>
                @endif
            </div>

            <hr class="m-0">
            <div class="nav flex-column ">
                <a class="nav-link text-black js-scroll-trigger" href="#about">About</a>
                <a class="nav-link text-black js-scroll-trigger" href="#experience">Experience</a>
                <a class="nav-link text-black js-scroll-trigger" href="#education">Education</a>
                <a class="nav-link text-black js-scroll-trigger" href="#skills">Skills</a>
                <a class="nav-link text-black js-scroll-trigger" href="{{ route ('account.resume') }}">My Resume</a>
            </div>
        </div>
        <!-- Main content -->
        <div class="col-md-9 bg-light">
            <!-- About -->
            <section class="resume-section p-5" id="about">
                <div class="w-100">
                    <h1 class="mb-3">{{ $information['personal_info']['first_name'] ?? 'Empty' }} <span
                            class="text-dark">{{ $information['personal_info']['last_name'] ?? '' }}</span></h1>
                    <h4 class="mb-3 text-secondary">{{ $information['personal_info']['profile_title'] ?? '' }}</h4>
                    <div class="subheading mb-5">
                        <a
                            href="mailto:{{ $information['contact_info']['email'] ?? '' }}">{{ $information['contact_info']['email'] ?? '' }}</a>
                    </div>
                    <p class="lead mb-5">{{ $information['personal_info']['about_me'] ?? '' }}</p>
                </div>
            </section>
            <hr class="m-0">

            <!-- Experience -->
            <section class="resume-section p-5" id="experience">
                <div class="w-100">
                    <h2 class="mb-5">Experience</h2>
                    <div class="timeline">
                        @foreach ($information['experience_info'] ?? [] as $index => $experience_info)
                            <div class="timeline-item {{ $index % 2 == 0 ? 'left' : 'right' }}">
                                <div class="timeline-content bg-white p-4 shadow-sm rounded">
                                    <h3 class="card-title">{{ $experience_info['job_title'] ?? '' }}</h3>
                                    <h5 class="card-subtitle mb-2 text-muted">
                                        {{ $experience_info['organization'] ?? '' }}</h5>
                                    <p class="card-text">{{ $experience_info['job_description'] ?? '' }}</p>
                                    <p class="text-muted">{{ $experience_info['job_start_date'] ?? '' }} -
                                        {{ $experience_info['job_end_date'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <hr class="m-0">
            <!-- Education -->
            <section class="resume-section p-5" id="education">
                <div class="w-100">
                    <h2 class="mb-5">Education</h2>
                    <div class="row">
                        @foreach ($information['education_info'] ?? [] as $education_info)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $education_info['degree_title'] ?? '' }}</h3>
                                        <h5 class="card-subtitle mb-2 text-muted">
                                            {{ $education_info['institute'] ?? '' }}</h5>
                                        <p class="card-text">{{ $education_info['education_description'] ?? '' }}</p>
                                        <p class="text-muted">{{ $education_info['edu_start_date'] ?? '' }} -
                                            {{ $education_info['edu_end_date'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <hr class="m-0">
            <!-- Skills -->
            <section class="resume-section p-5" id="skills">
                <div class="w-100">
                    <h2 class="mb-5">Skills</h2>
                    <ul class="skills-list">
                        @foreach ($information['skill_info'] ?? [] as $skill)
                            <li class="skill-item">
                                <i class="devicons devicons-{{ strtolower($skill['skill']) }}"></i>
                                {{ $skill['skill'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection