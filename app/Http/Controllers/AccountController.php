<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // This method will show registration page
    public function registration()
    {
        return view('front.account.registration');
    }

    //This method will save a user
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
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

    // public function updateProfilePic(Request $request){

    //     $id = Auth::user()->id;

    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|image'
    //     ]);

    //     if($validator->passes()){

    //         $image = $request->image;
    //         $ext  = $image->getClientOriginalExtension();
    //         $imageName = $id.'-'.time().'.'.$ext;
    //         $image->move(public_path('/profile_pic/'), $imageName);
            
    //         User::where('id', $id)->update(['image' => $imageName]);   

    //         session()->flash('success','Profile picture update successfully.');
            
    //         return response()->json([
    //             'status' => true,
    //             'errors' => []
    //         ]);


    //     } else {

    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors()
    //         ]);

    //     }
    // }

    public function updateProfilePic(Request $request){
        $id = Auth::user()->id;
    
        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);
    
        if($validator->passes()){
    
           
            $oldImage = User::where('id', $id)->first()->image;
    
            // Kiểm tra và xóa ảnh cũ nếu tồn tại
            if($oldImage && file_exists(public_path('/profile_pic/').$oldImage)){
                unlink(public_path('/profile_pic/').$oldImage);
            }
    
            // Xử lý ảnh mới
            $image = $request->image;
            $ext  = $image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic/'), $imageName);
            
            User::where('id', $id)->update(['image' => $imageName]);   
    
            session()->flash('success','Profile picture update successfully.');
            
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
}
