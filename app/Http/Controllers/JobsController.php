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
use App\Models\Resume;
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
        $resumes = [];
        if (Auth::check()) {
            $count = SavedJobs::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
                $resumes = Resume::where('user_id', Auth::id())->get();
        }
    
        $relatedJobs = $job->relatedJobs();
            return view('front.jobDetail', [
            'job' => $job,
            'count' => $count,
            'relatedJobs' => $relatedJobs,
            'resumes' => $resumes, 
        ]);
    }

    // public function applyJob(Request $request)
    // {
    //     $id = $request->id;
    //     $job = Job::find($id);
    
    //     $sendErrorResponse = function($message) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $message
    //         ]);
    //     };
    
    //     // Check if the job exists
    //     if (is_null($job)) {
    //         return $sendErrorResponse('Job does not exist.');
    //     }
    
    //     // You cannot apply to your own job
    //     $employer_id = $job->user_id;
    //     if ($employer_id == Auth::user()->id) {
    //         return $sendErrorResponse('You cannot apply to your own job.');
    //     }
    
    //     // Check if the user has already applied for this job
    //     $alreadyApplied = JobApplication::where([
    //         'user_id' => Auth::user()->id,
    //         'job_id' => $id
    //     ])->exists();
    
    //     if ($alreadyApplied) {
    //         return $sendErrorResponse('You already applied to this job.');
    //     }
    
    //     // Check if the job is full
    //     $approvedApplicationsCount = JobApplication::where('job_id', $id)
    //     ->where('status', 1) 
    //     ->count();
    
    //     if ($approvedApplicationsCount >= $job->vacancy) {
    //         $message = 'Job is Full, please find another job.';
    //         session()->flash('error', $message);
    //         return response()->json([
    //             'status' => false,
    //             'message' => $message
    //         ]);
    //     }
    
    //     // Handle CV file or resume
    //     $cvFilePath = '';
    //     $resumeId = null;
    
    //     if ($request->input('cvOption') == 'upload' && $request->hasFile('cv_file')) {
    //         // Handle file upload
    //         $file = $request->file('cv_file');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $filePath = 'uploads/cv_files/';
    //         $file->move(public_path($filePath), $fileName);
    //         $cvFilePath = $filePath . $fileName;
    //     } elseif ($request->input('cvOption') == 'existing') {
    //         $resumeId = $request->input('resume_id');
    //         $resume = Resume::find($resumeId);
    
    //         if (is_null($resume)) {
    //             return $sendErrorResponse('Selected resume not found.');
    //         }
    //     } else {
    //         return $sendErrorResponse('You need to upload a resume or choose one from your account.');
    //     }
    
    //     // Save the application
    //     $application = new JobApplication();
    //     $application->job_id = $id;
    //     $application->user_id = Auth::user()->id;
    //     $application->employer_id = $employer_id;
    //     $application->applied_date = now();
    //     $application->cv_file = $cvFilePath;
    //     $application->resume_id = $resumeId;
    //     $application->cover_letter = $request->input('cover_letter');
    //     $application->save();
    
    //     // Send Notification Email to Employer
    //     $employer = User::find($employer_id);
    //     $mailData = [
    //         'employer' => $employer,
    //         'user' => Auth::user(),
    //         'job' => $job,
    //     ];
    
    //     Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
    
    //     // Success message
    //     $message = 'You have successfully applied.';
    
    //     return response()->json([
    //         'status' => true,
    //         'message' => $message
    //     ]);
    // }

    public function applyJob(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);

        $sendErrorResponse = function($message) {
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        };

        // Check if the job exists
        if (is_null($job)) {
            return $sendErrorResponse('Job does not exist.');
        }

        // You cannot apply to your own job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            return $sendErrorResponse('You cannot apply to your own job.');
        }

        // Check if the user has already applied for this job
        $alreadyApplied = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->exists();

        if ($alreadyApplied) {
            return $sendErrorResponse('You already applied to this job.');
        }

        // Check if the job is full
        $approvedApplicationsCount = JobApplication::where('job_id', $id)
            ->where('status', 1) 
            ->count();

        if ($approvedApplicationsCount >= $job->vacancy) {
            $message = 'Job is Full, please find another job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // Handle CV file or resume
        $cvFilePath = '';
        $resumeId = null;

        if ($request->input('cvOption') == 'upload' && $request->hasFile('cv_file')) {
            // Handle file upload
            $file = $request->file('cv_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/cv_files/';
            $file->move(public_path($filePath), $fileName);
            $cvFilePath = $filePath . $fileName;
        } elseif ($request->input('cvOption') == 'existing') {
            $resumeId = $request->input('resume_id');
            $resume = Resume::find($resumeId);

            if (is_null($resume)) {
                return $sendErrorResponse('Selected resume not found.');
            }
        } else {
            return $sendErrorResponse('You need to upload a resume or choose one from your account.');
        }

        // Save the application
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->cv_file = $cvFilePath;
        $application->resume_id = $resumeId;
        $application->cover_letter = $request->input('cover_letter');
        $application->save();

        // Send Notification Email to Employer
        $employer = User::find($employer_id);
        $user = Auth::user();
        $mailData = [
            'employer' => $employer,
            'user' => $user,
            'job' => $job,
            'subject' => 'New Job Application Received',
        ];

        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        // Success message
        $message = 'You have successfully applied.';

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
