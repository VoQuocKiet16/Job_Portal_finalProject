<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobTypeController extends Controller
{

    public function index() {
    $jobtypes = JobType::orderBy('created_at','DESC')->paginate(10);
    return view('admin.job-type.list',[
        'jobtypes' => $jobtypes
    ]);
    }   

    public function create()
    {
        return view('admin.job-type.create');
    }

    public function saveJobType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jobtype = new JobType;
        $jobtype->name = $request->name;
        $jobtype->save();

        return redirect()->route('admin.jobtypes')->with('success', 'Job Type created successfully.');
    }

    public function edit($id){
        $jobtype = JobType::findOrFail($id);
        
        return view('admin.job-type.edit',[
            'jobtype' => $jobtype
        ]);
    }

    public function update($id, Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:1|max:20',
        ]);


        if ($validator->passes()) {

            $jobtype = JobType::find($id);
            $jobtype->name = $request->name;
            $jobtype->save();

            session()->flash('success','Job Type information updated successfully.');

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

    public function delete(Request $request) {
        $id = $request->id;

        $jobtype = JobType::find($id);

        if($jobtype == null){
            session()->flash('error', 'Job Type not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $jobtype->delete();
        session()->flash('success', 'Job Type deleted successfully');
        return response()->json([
            'status' => true,

        ]);
    }


}
