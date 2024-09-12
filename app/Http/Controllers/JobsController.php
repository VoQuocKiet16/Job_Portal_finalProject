<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobNotificationEmail;
use App\Models\Location;
use App\Models\SavedJobs;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->paginate(9);


        $jobs = Job::where('status', 1);

        // Search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        // Search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location_id', $request->location);
        }

        // Search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        $jobTypeArray = [];
        // Search using Job Type
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // Search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }


        $jobs = $jobs->with(['jobType', 'category']);

        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }


        $jobs = $jobs->paginate(6);


        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'locations' => $locations,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id)
    {
        $job = Job::where([
            'id' => $id,
            'status' => 1
        ])->with(['jobType', 'category'])->first();
    
        if ($job == null) {
            abort(404);
        }
    
        $count = 0;
    
        if (Auth::check()) {
            $count = SavedJobs::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
        }

        $relatedJobs = $job->relatedJobs();

        return view('front.jobDetail', [
            'job' => $job, 
            'count' => $count, 
            'relatedJobs' => $relatedJobs
        ]);
    
    }

    public function applyJob(Request $request) {
        $id = $request->id;
    
        $job = Job::where('id', $id)->first();
    
        // If job not found in the database
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

    
        // You cannot apply to your own job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            $message = 'You cannot apply to your own job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
    
        // You cannot apply for a job twice
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        
        if ($jobApplicationCount > 0) {
            $message = 'You already applied to this job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

            
        // Check if the job is full
        $applicationCount = JobApplication::where('job_id', $id)->count();
        if ($applicationCount >= $job->vacancy) {
            $message = 'Job is Full, please find another job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
    
        // Save the application
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();
    
        // Send Notification Email to Employer
        $employer = User::where('id', $employer_id)->first();
        
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];
    
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
    
        $message = 'You have successfully applied.';
    
        session()->flash('success', $message);
    
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    
   
    public function saveJob(Request $request) {

        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Job not found');

            return response()->json([
                'status' => false,
            ]);
        }

        
        // Check if the job is already saved
        $savedJob = SavedJobs::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->first();
    
        if ($savedJob) {
            // If already saved, remove it from saved jobs
            $savedJob->delete();
            session()->flash('success','You have successfully removed the job from your saved list.');
        } else {
            // If not saved, add it to saved jobs
            $newSavedJob = new SavedJobs();
            $newSavedJob->job_id = $id;
            $newSavedJob->user_id = Auth::user()->id;
            $newSavedJob->save();
            session()->flash('success','You have successfully saved the job.');
          
        }
    
        return response()->json([
            'status' => true,
        ]);

    }
    
}
