@extends('front.layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center " class=""
    data-bg="{{ asset('assets/images/banner5.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>

                <section class="section-1 py-5 ">
                    <div class="container">
                        <div class="card border-0 shadow p-5">
                            <form action="{{ route('jobs') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                        <input type="text" class="form-control" name="keyword" id="keyword"
                                            placeholder="Keywords">
                                    </div>
                                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                        <input type="text" class="form-control" name="location" id="location"
                                            placeholder="Location">
                                    </div>
                                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a category</option>
                                            @if ($newCategories->isNotEmpty())
                                                @foreach ($newCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                                        <div class="d-grid gap-2">
                                            {{-- <a href="jobs.html" class="btn btn-primary btn-block">Search</a> --}}
                                            <button class="btn btn-primary btn-block" type="submit">Search</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<section class="section-3 py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row">
                        @if ($featuredJobs->isNotEmpty())
                            @foreach ($featuredJobs as $featuredJob)
                                <div class="col-md-12">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body d-flex align-items-start">
                                            @if ($featuredJob->image)
                                                <div class="me-3">
                                                    <img src="{{ asset($featuredJob->image) }}" class="img-fluid" style="width: 70px; height: 70px; object-fit: cover;">
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h3 class="fs-5 pb-2 mb-0">{{ $featuredJob->title }}</h3>
                                                <p class="mb-0">Location</p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{ $featuredJob->location }}</span>
                                                </p>
                                            </div>
                                            <div class="text-end ms-3">
                                                <p class="mb-0"><strong>Salary:</strong> {{ $featuredJob->salary }}</p>
                                                <a href="{{ route('jobDetail', $featuredJob->id) }}" class="btn btn-outline-primary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No featured jobs available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row">
                        @if ($latestJobs->isNotEmpty())
                            @foreach ($latestJobs as $latestJob)
                                <div class="col-md-12">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body d-flex align-items-start">
                                            @if ($latestJob->image)
                                                <div class="me-3">
                                                    <img src="{{ asset($latestJob->image) }}" class="img-fluid" style="width: 70px; height: 70px; object-fit: cover;">
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h3 class="fs-5 pb-2 mb-0">{{ $latestJob->title }}</h3>
                                                <p class="mb-0">Location</p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{ $latestJob->location }}</span>
                                                </p>
                                            </div>
                                            <div class="text-end ms-3">
                                                <p class="mb-0"><strong>Salary:</strong> {{ $latestJob->salary }}</p>
                                                <a href="{{ route('jobDetail', $latestJob->id) }}" class="btn btn-outline-primary">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No latest jobs available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
