<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\RoleChangeRequest;
use App\Models\User;
use App\Notifications\RoleChangeRequestApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RoleChangeRequestNotification;
use App\Notifications\RoleChangeRequestRejected;

class RoleChangeRequestController extends Controller
{
    public function request()
    {
        return view('front.account.role.create');
    }

    public function store(Request $request)
    {
        $requestedRole = $request->requested_role;

        // Check if the user already has a pending role change request
        $existingRequest = RoleChangeRequest::where([
            'user_id' => Auth::id(),
            'requested_role' => $requestedRole,
            'approved' => false,
        ])->first();

        if ($existingRequest) {
            session()->flash('error', 'You have already submitted a request for this role. Please wait for approval.');
            return redirect()->back();
        }

        // Validate the requested role
        $request->validate([
            'requested_role' => 'required|string|max:255',
        ]);

        // Create a new role change request
        RoleChangeRequest::create([
            'user_id' => Auth::id(),
            'requested_role' => $requestedRole,
        ]);

        // Notify admins
        $adminUsers = User::whereRole('admin')->get();
        Notification::send($adminUsers, new RoleChangeRequestNotification(Auth::user()));

        session()->flash('success', 'Your role change request has been submitted successfully.');
        return redirect()->back();
    }




    public function index()
    {
        $requests = RoleChangeRequest::where('approved', false)->get();
        return view('front.account.role.index', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        $roleRequest = RoleChangeRequest::findOrFail($id);
        $roleRequest->approved = true;
        $roleRequest->save();

        // Update user's role directly
        $user = $roleRequest->user;
        $user->role = $roleRequest->requested_role; // Ensure you have a 'role' column in your 'users' table
        $user->save();

        $user->notify(new RoleChangeRequestApproved($roleRequest->requested_role));

        return redirect()->route('admin.role_change_requests.index')->with('status', 'Role change request approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $roleRequest = RoleChangeRequest::findOrFail($id);
        $roleRequest->delete();

        $roleRequest->user->notify(new RoleChangeRequestRejected());

        return redirect()->route('admin.role_change_requests.index')->with('status', 'Role change request rejected successfully!');
    }


}
