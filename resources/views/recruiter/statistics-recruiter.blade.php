@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5" style="max-width: 1400px;">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Statistics</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                @include('recruiter.sidebar') <!-- Sidebar inclusion -->
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="fs-4 mb-3 text-center" data-aos="fade-up">Recruiter Statistics</h3>

                        <div class="row mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-md-6">
                                <div class="card text-white bg-primary shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total Jobs Posted</h5>
                                        <p class="card-text display-4 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">
                                            {{ $totalJobsPosted }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card text-white bg-success shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total Applications Received</h5>
                                        <p class="card-text display-4 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">
                                            {{ $totalApplications }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="col-md-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Top Job by Applications</h5>
                                        @if($topJobByApplications)
                                            <p>{{ $topJobByApplications->title }} - {{ $topJobByApplications->total }} applications</p>
                                        @else
                                            <p>No applications yet.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Jobs Posted by Category</h5>
                                        <canvas id="jobsByCategoryChart" style="max-height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Applications per Job</h5>
                                        <canvas id="applicationsPerJobChart" style="max-height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    // Jobs by Category Chart
    var ctx1 = document.getElementById('jobsByCategoryChart').getContext('2d');
    var jobsByCategoryChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: @json($jobsByCategory->pluck('name')),
            datasets: [{
                data: @json($jobsByCategory->pluck('total')),
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Ensure the chart respects the canvas size
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Applications per Job Chart
    var ctx2 = document.getElementById('applicationsPerJobChart').getContext('2d');
    var applicationsPerJobChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($applicationsPerJob->pluck('title')),
            datasets: [{
                label: 'Applications',
                data: @json($applicationsPerJob->pluck('total')),
                backgroundColor: '#4bc0c0',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Ensure the chart respects the canvas size
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection
