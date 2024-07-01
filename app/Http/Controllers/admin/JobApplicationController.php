<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(){
        $applications = JobApplication::orderBy('created_at', 'DESC')->with('job', 'user', 'employer')->paginate(10);
        return view('admin.job-applications.list',[
            'applications' => $applications
        ]);
    }

    public function delete(Request $request) {
        $id = $request->id;

        $user = JobApplication::find($id);

        if($user == null){
            session()->flash('error', 'JobApplication not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $user->delete();
        session()->flash('success', 'JobApplication deleted successfully');
        return response()->json([
            'status' => true,

        ]);
    }
}
