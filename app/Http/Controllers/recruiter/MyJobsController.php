<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyJobsController extends Controller
{
    public function myJobs()
    {

        $jobs = Job::where('user_id', Auth::user()->id)
            ->with(['jobType', 'applications', 'location']) 
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('recruiter.jobs.my-jobs', [
            'jobs' => $jobs,
        ]);
    }

    
    

    public function removeMyJobs(Request $request)
    {
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId,
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Either job deleted or nor found');
            return response()->json([
                'status' => true,
            ]);
        }

        Job::where('id', $request->jobId)->delete();
        session()->flash('success', 'Job removed successfully');
        return response()->json([
            'status' => true,
        ]);
    }
    
    public function createJob()
    {
        $locations = Location::orderBy('name', 'ASC')->where('status', 1)->get();
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('recruiter.jobs.create', [
            'locations' =>     $locations,
            'categories' =>     $categories,
            'jobTypes' =>      $jobTypes,
        ]);
    }

    public function saveJob(Request $request)
    {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'location_description' => 'required|max:50',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'company_name' => 'required|min:3|max:75',
        ];
    
        // $validator = Validator::make($request->all(), $rules);
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location_id = $request->location;
            $job->location_description = $request->location_description;
            $job->description = $request->description;
    
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/jobs/';
                $file->move($path, $filename);
                $job->image = $path . $filename;
            }
    
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->save();
    
            session()->flash('success', 'Job added successfully.');
    
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateJob(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'location_description' => 'required|max:50',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'company_name' => 'required|min:3|max:75',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()) {
            $job = Job::find($id);
    
            if (!$job) {
                return response()->json([
                    'status' => false,
                    'errors' => ['Job not found']
                ]);
            }
    
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location_id = $request->location;
            $job->location_description = $request->location_description;
            $job->description = $request->description;
    
            if ($request->hasFile('image')) {
                if ($job->image && file_exists(public_path($job->image))) {
                    unlink(public_path($job->image));
                }
    
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/jobs/';
                $file->move(public_path($path), $filename);
                $job->image = $path . $filename;
            }
    
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
    
            $job->status = $request->status;
            $job->save();
            session()->flash('success', 'Job updated successfully.');
    
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function editJob(Request $request, $id)
    {
        $locations = Location::orderBy('name', 'ASC')->where('status', 1)->get();
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('recruiter.jobs.edit', [
            'categories' => $categories,
            'locations' => $locations,
            'jobTypes' => $jobTypes,
            'job' => $job,
        ]);
    }




}
