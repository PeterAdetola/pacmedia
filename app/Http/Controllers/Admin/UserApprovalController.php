<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountApprovedNotification;
use App\Notifications\AccountSuspendedNotification;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    /**
     * List all pending users awaiting admin approval.
     */
    public function index()
    {
        $pendingUsers  = User::where('status', 'pending')->latest()->get();
        $approvedUsers = User::where('status', 'approved')->latest()->get();
        $suspendedUsers = User::where('status', 'suspended')->latest()->get();

        return view('admin.users.index', compact('pendingUsers', 'approvedUsers', 'suspendedUsers'));
    }

    /**
     * Approve a user and notify them by email.
     */
    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);

        try {
            $user->notify(new AccountApprovedNotification());
        } catch (\Exception $e) {
            \Log::error('Failed to send approval notification to ' . $user->email . ': ' . $e->getMessage());
        }

        return back()->with('success', "{$user->name} has been approved and notified by email.");
    }

    /**
     * Suspend a user account.
     */
    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);

        try {
            $user->notify(new AccountSuspendedNotification());
        } catch (\Exception $e) {
            \Log::error('Failed to send suspension notification to ' . $user->email . ': ' . $e->getMessage());
        }

        return back()->with('success', "{$user->name} has been suspended.");
    }

    /**
     * Restore a suspended user back to approved.
     */
    public function restore(User $user)
    {
        $user->update(['status' => 'approved']);

        return back()->with('success', "{$user->name}'s account has been restored.");
    }
}
