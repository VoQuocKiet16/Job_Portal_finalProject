<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function indexAdmin() {
        return view('admin.dashboard');
    }

    public function indexRecruiter() {
        return view('recruiter.dashboard');
    }
    public function statisticsAdmin() {
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalRecruiters = User::where('role', 'recruiter')->count();
        $totalApplicants = User::where('role', 'user')->count();
        $totalApplications = JobApplication::count();
    
        // Get the total number of categories
        $totalCategories = Category::count();
    
        // Get the total number of jobs
        $totalJobs = Job::count();
    
        // Get applications per job along with job titles
        $applicationsPerJob = JobApplication::select('jobs.title as job_title', DB::raw('count(job_applications.id) as total'))
                                            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
                                            ->groupBy('jobs.title')
                                            ->get();
    
        // Prepare data for the application chart
        $applicationChartLabels = $applicationsPerJob->pluck('job_title')->toArray();
        $applicationChartData = $applicationsPerJob->pluck('total')->toArray();
    
        return view('admin.statistics-admin', compact(
            'totalUsers', 
            'totalRecruiters', 
            'totalApplicants', 
            'totalApplications', 
            'totalCategories', // Thêm biến totalCategories
            'totalJobs', // Thêm biến totalJobs
            'applicationsPerJob', 
            'applicationChartLabels', 
            'applicationChartData'
        ));
    }

    public function statisticsRecruiter()
    {
        $employer_id = auth()->id();
        $user_id = auth()->id();


        // Total Jobs Posted
        // $totalJobsPosted = JobApplication::where('employer_id', $employer_id)->count();
        $totalJobsPosted = Job::where('user_id', $user_id)->count();


        // Jobs Posted by Category
        $jobsByCategory = Job::select('categories.name', DB::raw('count(jobs.id) as total'))
            ->join('categories', 'jobs.category_id', '=', 'categories.id')
            ->where('user_id', $user_id)
            ->groupBy('categories.name')
            ->get();


        // Total Applications Received
        $totalApplications = JobApplication::whereIn('job_id', function ($query) use ($employer_id) {
            $query->select('id')
                ->from('jobs')
                ->where('employer_id', $employer_id);
        })->count();

        // Applications per Job
        $applicationsPerJob = Job::select('jobs.title', DB::raw('count(job_applications.id) as total'))
            ->leftJoin('job_applications', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.user_id', $user_id)
            ->groupBy('jobs.title')
            ->get();


        // Top Job by Applications
        $topJobByApplications = Job::select('jobs.title', DB::raw('count(job_applications.id) as total'))
            ->leftJoin('job_applications', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.user_id', $user_id)
            ->groupBy('jobs.title')
            ->orderBy('total', 'desc')
            ->first();

      

        return view('recruiter.statistics-recruiter', compact(
            'totalJobsPosted',
            'jobsByCategory',
            'totalApplications',
            'applicationsPerJob',
            'topJobByApplications',

        ));
    }
    
    
    
    
}
