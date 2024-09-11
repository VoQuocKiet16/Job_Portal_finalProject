<?php

namespace App\Http\Controllers;

use App\Models\ContactInformation;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\PersonalInformation;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id(); // Get the ID of the logged-in user
        $resumes = Resume::where('user_id', $user_id)->paginate(3); // Fetch and paginate the resumes

        $user_data = [];

        if ($resumes->isNotEmpty()) {
            foreach ($resumes as $resume) {
                $user_info = [];

                $personal_info = PersonalInformation::where('resume_id', $resume->id)->first();
                if ($personal_info) {
                    $user_info['personal_info'] = $personal_info->toArray();
                } else {
                    $user_info['personal_info'] = ['profile_title' => '', 'first_name' => '', 'last_name' => ''];
                }

                $contact_info = ContactInformation::where('resume_id', $resume->id)->first();
                if ($contact_info) {
                    $user_info['contact_info'] = $contact_info->toArray();
                } else {
                    $user_info['contact_info'] = ['website' => '', 'linkedin_link' => ''];
                }

                $education_info = Education::where('resume_id', $resume->id)->get();
                if ($education_info->isNotEmpty()) {
                    $user_info['education_info'] = $education_info->toArray();
                } else {
                    $user_info['education_info'] = [];
                }

                $experience_info = Experience::where('resume_id', $resume->id)->get();
                if ($experience_info->isNotEmpty()) {
                    $user_info['experience_info'] = $experience_info->toArray();
                } else {
                    $user_info['experience_info'] = [];
                }

                $skill_info = Skill::where('resume_id', $resume->id)->get();
                if ($skill_info->isNotEmpty()) {
                    $user_info['skill_info'] = $skill_info->toArray();
                } else {
                    $user_info['skill_info'] = [];
                }

                $user_info['resume_id'] = $resume->id;
                $user_data[] = $user_info;
            }
        }

        return view('front.account.resume.index', ['users_data' => $user_data, 'resumes' => $resumes]);
    }




    // public function view($id)
    // {
    //     $resume = Resume::with([
    //         'personalInformation', 
    //         'contactInformation', 
    //         'education', 
    //         'experience' => function ($query) {
    //             $query->orderBy('job_start_date', 'asc'); 
    //         }, 
    //         'skill'
    //     ])->findOrFail($id);
    
    //     $information = [];
    
    //     if ($resume->personalInformation) {
    //         $information['personal_info'] = $resume->personalInformation->toArray();
    //     }
    
    //     if ($resume->contactInformation) {
    //         $information['contact_info'] = $resume->contactInformation->toArray();
    //     }
    
    //     if ($resume->education->isNotEmpty()) {
    //         $information['education_info'] = $resume->education->toArray();
    //     } else {
    //         $information['education_info'] = [];
    //     }
    
    //     if ($resume->experience->isNotEmpty()) {
    //         $information['experience_info'] = $resume->experience->toArray();
    //     } else {
    //         $information['experience_info'] = [];
    //     }
    
    //     if ($resume->skill->isNotEmpty()) {
    //         $information['skill_info'] = $resume->skill->toArray();
    //     } else {
    //         $information['skill_info'] = [];
    //     }
    
    //     return view('front.account.resume.view', compact('information'));
    // }

    public function view($id)
{
    $resume = Resume::with([
        'personalInformation', 
        'contactInformation', 
        'education', 
        'experience' => function ($query) {
            $query->orderBy('job_start_date', 'asc'); 
        }, 
        'skill'
    ])->findOrFail($id);

    $information = [];

    if ($resume->personalInformation) {
        $information['personal_info'] = $resume->personalInformation->toArray();
    }

    if ($resume->contactInformation) {
        $information['contact_info'] = $resume->contactInformation->toArray();
    }

    if ($resume->education->isNotEmpty()) {
        $information['education_info'] = $resume->education->toArray();
    } else {
        $information['education_info'] = [];
    }

    if ($resume->experience->isNotEmpty()) {
        $information['experience_info'] = $resume->experience->toArray();
    } else {
        $information['experience_info'] = [];
    }

    if ($resume->skill->isNotEmpty()) {
        $information['skill_info'] = $resume->skill->toArray();
    } else {
        $information['skill_info'] = [];
    }

    // Pass both $information and $resume to the view
    return view('front.account.resume.view', compact('information', 'resume'));
}

    

    public function createResume()
    {
        return view('front.account.resume.create');
    }
    public function saveResume(Request $request)
    {
        $user_id = Auth::id();

        $resume = new Resume();
        $resume->user_id = $user_id;
        $resume->status = 0;
        $resume->save();

        $personal_info = new PersonalInformation();
        $personal_info->resume_id = $resume->id;
        $personal_info->first_name = $request->first_name;
        $personal_info->last_name = $request->last_name;
        $personal_info->profile_title = $request->profile_title;
        $personal_info->about_me = $request->about_me;
        $personal_info->save();

        $contact_info = new ContactInformation();
        $contact_info->resume_id = $resume->id;
        $contact_info->website = $request->website;
        $contact_info->linkedin_link = $request->linkedin_link;
        $contact_info->save();

        foreach ($request->degree_title as $index => $degree_title) {
            $education_info = new Education();
            $education_info->resume_id = $resume->id;
            $education_info->degree_title = $degree_title;
            $education_info->institute = $request->institute[$index];
            $education_info->edu_start_date = $request->edu_start_date[$index];
            $education_info->edu_end_date = $request->edu_end_date[$index];
            $education_info->education_description = $request->education_description[$index];
            $education_info->save();
        }

        foreach ($request->job_title as $index => $job_title) {
            $experience_info = new Experience();
            $experience_info->resume_id = $resume->id;
            $experience_info->job_title = $job_title;
            $experience_info->organization = $request->organization[$index];
            $experience_info->job_start_date = $request->job_start_date[$index];
            $experience_info->job_end_date = $request->job_end_date[$index];
            $experience_info->job_description = $request->job_description[$index];
            $experience_info->save();
        }

        if ($request->has('skills') && is_array($request->skills)) {
            foreach ($request->skills as $skill) {
                $skill_info = new Skill();
                $skill_info->resume_id = $resume->id;
                $skill_info->skill = $skill;
                $skill_info->save();
            }
        }
        return redirect()->route('account.resume', ['resumeId' => $resume->id]);
    }


    public function toggleResumeStatus($id)
    {
        $resume = Resume::findOrFail($id);
    
        // Toggle the status
        $resume->status = !$resume->status;
        $resume->save();
    
        session()->flash('success', 'Resume status updated successfully.');
    
        return redirect()->back();
    }

    public function delete(Request $request) {
        $id = $request->id;

        $resume = Resume::find($id);

        if($resume == null){
            session()->flash('error', 'Resume not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $resume->delete();
        session()->flash('success', 'Resume deleted successfully');
        return response()->json([
            'status' => true,

        ]);
    }

    public function showResume(Request $request)
    {
        $resumes = Resume::where('status', 1);

        // Search using degree title
        if (!empty($request->degree_title)) {
            $resumes = $resumes->whereHas('education', function ($query) use ($request) {
                $query->where('degree_title', 'like', '%' . $request->degree_title . '%');
            });
        }

        // Search using profile title
        if (!empty($request->profile_title)) {
            $resumes = $resumes->whereHas('personalInformation', function ($query) use ($request) {
                $query->where('profile_title', 'like', '%' . $request->profile_title . '%');
            });
        }

        // Search using skill
        if (!empty($request->skill)) {
            $resumes = $resumes->whereHas('skill', function ($query) use ($request) {
                $query->where('skill', 'like', '%' . $request->skill . '%');
            });
        }

        // Paginate the results
        $resumes = $resumes->with(['personalInformation', 'education', 'experience', 'skill'])->paginate(6);

        return view('front.account.resume.show', compact('resumes'));
    }

    public function editResume($id)
    {
        $resume = Resume::with(['personalInformation', 'contactInformation', 'education', 'experience', 'skill'])->findOrFail($id);

        return view('front.account.resume.edit', compact('resume'));
    }

    public function updateResume(Request $request, $id)
    {
        $resume = Resume::findOrFail($id);

        $resume->save();


        $personal_info = PersonalInformation::where('resume_id', $resume->id)->first();
        if ($personal_info) {
            $personal_info->first_name = $request->first_name;
            $personal_info->last_name = $request->last_name;
            $personal_info->profile_title = $request->profile_title;
            $personal_info->about_me = $request->about_me;
            $personal_info->save();
        }


        $contact_info = ContactInformation::where('resume_id', $resume->id)->first();
        if ($contact_info) {
            $contact_info->website = $request->website;
            $contact_info->linkedin_link = $request->linkedin_link;
            $contact_info->save();
        }

        Education::where('resume_id', $resume->id)->delete();
        foreach ($request->degree_title as $index => $degree_title) {
            $education_info = new Education();
            $education_info->resume_id = $resume->id;
            $education_info->degree_title = $degree_title;
            $education_info->institute = $request->institute[$index];
            $education_info->edu_start_date = $request->edu_start_date[$index];
            $education_info->edu_end_date = $request->edu_end_date[$index];
            $education_info->education_description = $request->education_description[$index];
            $education_info->save();
        }

        Experience::where('resume_id', $resume->id)->delete();
        foreach ($request->job_title as $index => $job_title) {
            $experience_info = new Experience();
            $experience_info->resume_id = $resume->id;
            $experience_info->job_title = $job_title;
            $experience_info->organization = $request->organization[$index];
            $experience_info->job_start_date = $request->job_start_date[$index];
            $experience_info->job_end_date = $request->job_end_date[$index];
            $experience_info->job_description = $request->job_description[$index];
            $experience_info->save();
        }

        Skill::where('resume_id', $resume->id)->delete();
        if ($request->has('skills') && is_array($request->skills)) {
            foreach ($request->skills as $skill) {
                $skill_info = new Skill();
                $skill_info->resume_id = $resume->id;
                $skill_info->skill = $skill;
                $skill_info->save();
            }
        }

        return redirect()->route('resume.view', $resume->id)->with('success', 'Resume updated successfully.');
    }






    
    

}
