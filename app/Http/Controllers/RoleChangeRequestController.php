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
    public function create()
    {
        return view('front.account.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'requested_role' => 'required|string|max:255',
        ]);

        RoleChangeRequest::create([
            'user_id' => Auth::id(),
            'requested_role' => $request->requested_role,
        ]);

        // Notify admin (assuming you have a method to get admin users)
        $adminUsers = User::whereRole('admin')->get();
        Notification::send($adminUsers, new RoleChangeRequestNotification(Auth::user()));

        return redirect()->route('account.profile')->with('status', 'Role change request submitted successfully!');
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
