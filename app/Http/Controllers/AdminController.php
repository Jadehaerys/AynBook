<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // admin dashboard — show all users + their roles
    public function index()
    {
        $users = User::orderBy('created_at')->get();
        return view('admin.index', compact('users'));
    }

    // change a user's role — admin can't demote themselves
    public function updateRole(User $user, Request $request)
    {
        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        if ($user->id === Auth::id()) {
            return back()->with('error', "You can't change your own role.");
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "{$user->name}'s role updated to {$request->role}.");
    }

    // delete a user — can't delete yourself
    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', "You can't delete your own account from here.");
        }

        $user->delete();

        return back()->with('success', "{$user->name} has been removed.");
    }
}
