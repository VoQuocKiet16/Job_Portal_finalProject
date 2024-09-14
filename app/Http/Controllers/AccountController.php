<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Mail\VerifyAccountEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJobs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller 
{
    // This method will show registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
            'recruiter' => 'required|in:yes,no',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            // Set the role based on the recruiter's selection
            if ($request->recruiter == 'yes') {
                $user->role = 'recruiter';
            } else {
                $user->role = 'user';
            }

            $user->save();

            session()->flash(
                'success',
                'You have registered successfully.'
            );

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

    // This method will show login page
    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Email or Password is incorrect');
            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    // This method will show profile page
    public function profile()
    {
        // dd(Auth::user());

        $id = Auth::user()->id;

        $user = User::where('id', $id)->first();

        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    // This method will update profile
    public function updateProfile(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile update successfully.');

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

    // This method will logout account
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

   
    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {


            $oldImage = User::where('id', $id)->first()->image;


            if ($oldImage && file_exists(public_path('/profile_pic/') . $oldImage)) {
                unlink(public_path('/profile_pic/') . $oldImage);
            }


            $image = $request->image;
            $ext  = $image->getClientOriginalExtension();
            $imageName = $id . '-' . time() . '.' . $ext;
            $image->move(public_path('/profile_pic/'), $imageName);

            User::where('id', $id)->update(['image' => $imageName]);

            session()->flash('success', 'Profile picture update successfully.');

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

    public function myJobApplications()
    {
        $jobApplications = JobApplication::where('user_id', Auth::user()->id)
            ->with(['job', 'job.jobType', 'job.applications'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.my-job-applications', [
            'jobApplications' => $jobApplications
        ]);
    }


    public function removeAppliedJobs(Request $request)
    {
        // Fetch the job application based on the provided ID and authenticated user
        $jobApplication = JobApplication::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
        ])->first();
 
        if ($jobApplication == null) {
            session()->flash('error', 'Job application not found');  
            return response()->json([
                'status' => false,
            ]);
        }

        // Proceed to delete the found job application
        $jobApplication->delete();
        session()->flash('success', 'Job application removed successfully.');
        return response()->json([
            'status' => true,
        ]);
    }



    public function listSavedJobs()
    {
        $savedJobs = SavedJobs::where([
            'user_id' => Auth::user()->id
        ])->with(['job', 'job.jobType', 'job.applications'])->orderby('created_at', 'DESC')->paginate(10);

        return view('front.account.job.saved-jobs', [
            'savedJobs' => $savedJobs
        ]);
    }


    public function removeSavedJob(Request $request)
    {
        $savedJob = SavedJobs::where(
            [
                'id' => $request->id,
                'user_id' => Auth::user()->id
            ]
        )->first();

        if ($savedJob == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
            ]);
        }

        SavedJobs::find($request->id)->delete();
        session()->flash('success', 'The job has been successfully removed from your favorites list.');

        return response()->json([
            'status' => true,
        ]);
    }
    
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error','Your old password is incorrect.');
            return response()->json([
                'status' => true                
            ]);
        }


        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);  
        $user->save();

        session()->flash('success','Password updated successfully.');
        return response()->json([
            'status' => true                
        ]);

    }

    public function forgotPassword(){
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request){
        $validator = Validator::make($request -> all(),[
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(10);

        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' =>$request->email,
            'token' => $token,
            'created_at' => now()

        ]);

         // Send Email here
         $user = User::where('email',$request->email)->first();
         $mailData =  [
             'token' => $token,
             'user' => $user,
             'subject' => 'You have requested to change your password.'
         ];
 
         Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

         return redirect()->route('account.forgotPassword')->with('success','Reset password email has been sent to your inbox.');
    }

    public function resetPassword($tokenString) {
        $token = DB::table('password_reset_tokens')->where('token', $tokenString)->first();
    
        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid token.');
        }
    
    
        $createdTime = Carbon::parse($token->created_at);
        if (Carbon::now()->diffInMinutes($createdTime) >= 1) {
            DB::table('password_reset_tokens')->where('token', $tokenString)->delete();
            return redirect()->route('account.forgotPassword')->with('error', 'The reset link has expired. Please request a new one.');
        }
    
        return view('front.account.reset-password', [
            'tokenString' => $tokenString
        ]);
    }

    public function processResetPassword(Request $request) {
        $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();
    
        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid token.');
        }
    
      
        $createdTime = Carbon::parse($token->created_at);
        if (Carbon::now()->diffInMinutes($createdTime) >= 1) {
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();
            return redirect()->route('account.forgotPassword')->with('error', 'The reset link has expired. Please request a new one.');
        }
        
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('account.resetPassword', $request->token)->withErrors($validator);
        }
    
        User::where('email', $token->email)->update([
            'password' => Hash::make($request->new_password)
        ]);
    
    
        DB::table('password_reset_tokens')->where('token', $request->token)->delete();
    
        return redirect()->route('account.login')->with('success', 'You have successfully changed your password.');
    }

    

    
}
