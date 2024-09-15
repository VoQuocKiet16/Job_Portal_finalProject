<?php

namespace App\Http\Controllers\recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyApplicantsController extends Controller
{
    public function showApplications()
    {
        $applications = JobApplication::where('employer_id', Auth::user()->id)
            ->with(['user', 'job'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10); 
    
        return view('recruiter.applicants.my-applicants', [
            'applications' => $applications,
        ]);
    }

    public function approveApplication($id)
    {
        // Fetch the application to be approved
        $application = JobApplication::find($id);

        if (!$application) {
            session()->flash('error', 'Application not found.');
            return redirect()->back();  
        }

        // Get the job associated with this application
        $job = $application->job;

        // Count the number of approved applications for this job
        $approvedApplicationsCount = $job->applications()->where('status', 1)->count();

        // Check if the number of approved applications has reached the vacancy limit
        if ($approvedApplicationsCount >= $job->vacancy) {
            // Instead of a regular session flash, use SweetAlert2 for this message
            return redirect()->back()->with('swal_message', 'This job has already reached the maximum number of approved applicants.');
        }

        // If the job is not full, approve the application
        $application->status = 1; // 1 - Approved
        $application->save();

        session()->flash('success', 'Application approved successfully.');
        return redirect()->route('recruiter.applications');
    }

    
    public function rejectApplication($id)
    {
        $application = JobApplication::find($id);
    
        if (!$application) {
            session()->flash('error', 'Application not found.');
            return redirect()->back(); 
        }
    
        // Update the status to Rejected
        $application->status = 0; // 0 - Rejected
        $application->save();
    
        session()->flash('success', 'Application rejected successfully.');
    
        return redirect()->route('recruiter.applications');
    }

    public function viewApplicationDetail($id)
    {
        $application = JobApplication::with(['user', 'job'])->find($id);
        
        if (!$application || $application->employer_id != Auth::user()->id) {
            session()->flash('error', 'Application not found or you are not authorized to view this.');
            return redirect()->route('recruiter.applications');
        }

      
          
        $resume = Resume::find($application->resume_id);

        return view('recruiter.applicants.view', [
            'application' => $application,
            'resume' => $resume,
        ]);
    }

    public function removeMyApplicants(Request $request)
    {
        $application = JobApplication::where([
            'employer_id' => Auth::user()->id,
            'id' => $request->applicantId,
        ])->first();
    
        if ($application == null) {
            session()->flash('error', 'Application not found or already deleted.');
            return response()->json([
                'status' => false,
            ]);
        }
    
        JobApplication::where('id', $request->applicantId)->delete();
        session()->flash('success', 'Job application removed successfully.');
        return response()->json([
            'status' => true,
        ]);
    }

    public function viewResumeDetail($id)
    {

        $application = JobApplication::where('resume_id', $id)
            ->where('employer_id', Auth::user()->id) 
            ->first();

        if (!$application) {
            session()->flash('error', 'You do not have permission to view this resume.');
            return redirect()->back();
        }

        $resume = Resume::with([
            'personalInformation',
            'contactInformation',
            'education',
            'experience' => function ($query) {
                $query->orderBy('job_start_date', 'asc');
            },
            'skill'
        ])->findOrFail($id);


        if ($resume->status == 0 && Auth::user()->id != $application->employer_id) {
            session()->flash('error', 'Resume is private and you do not have permission to view it.');
            return redirect()->back();
        }


        $information = [
            'personal_info' => $resume->personalInformation ? $resume->personalInformation->toArray() : null,
            'contact_info' => $resume->contactInformation ? $resume->contactInformation->toArray() : null,
            'education_info' => $resume->education->isNotEmpty() ? $resume->education->toArray() : [],
            'experience_info' => $resume->experience->isNotEmpty() ? $resume->experience->toArray() : [],
            'skill_info' => $resume->skill->isNotEmpty() ? $resume->skill->toArray() : []
        ];


        return view('front.account.resume.view', compact('information', 'resume'));
    }

}
