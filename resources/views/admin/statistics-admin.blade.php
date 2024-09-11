@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5" style="max-width: 1400px;">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 bg-light shadow-sm">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Statistics</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="fs-4 mb-0">Admin Statistics</h3>
                            </div>

                            <!-- Tổng số Categories và Jobs -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card text-white bg-warning shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Categories</h5>
                                            <p class="card-text display-4 fw-bold" style=" text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">{{ $totalCategories }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-white bg-danger shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Jobs</h5>
                                            <p class="card-text display-4 fw-bold" style=" text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">{{ $totalJobs }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Users, Recruiters, and Applicants -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card text-white bg-primary shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Accounts</h5>
                                            <p class="card-text display-4 fw-bold" style=" text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">{{ $totalUsers }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white bg-success shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Recruiters</h5>
                                            <p class="card-text display-4 fw-bold" style=" text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">{{ $totalRecruiters }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white bg-info shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Users</h5>
                                            <p class="card-text display-4 fw-bold" style=" text-shadow: 2px 2px 8px rgba(0,0,0,0.5); color: white;">{{ $totalApplicants }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Chart -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">User Chart</h5>
                                            <canvas id="userChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Applications -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Total Applications</h5>
                                            <p class="card-text display-4">{{ $totalApplications }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Application Chart</h5>
                                            <canvas id="applicationChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications by Job -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Applications by Job</h5>
                                            <table class="table table-hover table-striped mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th scope="col">Job Title</th>
                                                        <th scope="col">Total Applications</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($applicationsPerJob as $application)
                                                        <tr>
                                                            <td>{{ $application->job_title }}</td>

                                                            <td>{{ $application->total }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
    <script>
        // User Chart
        var userCtx = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Recruiters', 'Applicants'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $totalUsers }}, {{ $totalRecruiters }}, {{ $totalApplicants }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(0, 188, 212, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(0, 188, 212, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
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

        // Application Chart
        var applicationCtx = document.getElementById('applicationChart').getContext('2d');
        var applicationChart = new Chart(applicationCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($applicationChartLabels) !!},
                datasets: [{
                    label: 'Applications Count',
                    data: {!! json_encode($applicationChartData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
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
    </script>
@endsection
