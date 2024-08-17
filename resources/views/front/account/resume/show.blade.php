@extends('front.layouts.app')

@section('main')
    <section class="section-3 py-5 bg-2">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10">
                    <h2>Find Resumes</h2>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form action="{{ route('resumes') }}" method="GET" name="searchForm" id="searchForm">
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Degree Title</h2>
                                <input value="{{ Request::get('degree_title') }}" type="text" name="degree_title"
                                    id="degree_title" placeholder="Degree Title" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Profile Title</h2>
                                <input value="{{ Request::get('profile_title') }}" type="text" name="profile_title"
                                    id="profile_title" placeholder="Profile Title" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Skill</h2>
                                <input value="{{ Request::get('skill') }}" type="text" name="skill" id="skill"
                                    placeholder="Skill" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('resumes') }}" class="btn btn-primary mt-3">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="resume_listing_area">
                        <div class="resume_lists">
                            <div class="row">
                                @if ($resumes->isNotEmpty())
                                    @foreach ($resumes as $resume)
                                        <div class="col-md-12">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body d-flex align-items-start">
                                                    <!-- Display the avatar from User model -->
                                                    @if ($resume->user && $resume->user->image)
                                                    <div class="me-3">
                                                        <img src="{{ asset('profile_pic/' . $resume->user->image) }}"  class="img-fluid" style="width: 120px; height: 120px; object-fit: cover;">
                                                    </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h3 class="fs-5 pb-2 mb-0">{{ $resume->personalInformation->profile_title }}</h3>
                                                        <p class="mb-2"><strong>Name:</strong>
                                                            {{ $resume->personalInformation->first_name }}
                                                            {{ $resume->personalInformation->last_name }}</p>                                          
                                                            {{ Str::words(strip_tags($resume->personalInformation->about_me), 10, '...') }}
                                                        </p>
                                                    </div>
                                                    <div class="text-end ms-3">
                                                        <a href="{{ route('resume.view', $resume->id) }}"
                                                            class="btn btn-outline-primary">View Resume</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12">
                                        {{ $resumes->withQueryString()->links() }}
                                    </div>
                                @else
                                    <div class="col-md-12">No resumes found</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
