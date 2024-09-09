<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index() {
        $locations = Location::orderBy('created_at','DESC')->paginate(10);
        return view('admin.location.list',[
            'locations' => $locations
        ]);
    }

    public function create()
    {
        return view('admin.location.create');
    }

    public function saveLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = new Location;
        $location->name = $request->name;
        $location->save();

        return redirect()->route('admin.locations')->with('success', 'Location created successfully.');
    }

    public function edit($id){
        $location = Location::findOrFail($id);
        
        return view('admin.location.edit',[
            'location' => $location
        ]);
    }

    public function update($id, Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:1|max:20',
        ]);


        if ($validator->passes()) {

            $location = Location::find($id);
            $location->name = $request->name;
            $location->save();

            session()->flash('success','Location information updated successfully.');

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

        $location = Location::find($id);

        if($location == null){
            session()->flash('error', 'Location not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $location->delete();
        session()->flash('success', 'Location deleted successfully');
        return response()->json([
            'status' => true,

        ]);
    }
}
