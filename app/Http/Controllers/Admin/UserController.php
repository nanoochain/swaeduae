<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'is_admin' => 'nullable|boolean',
        ]);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => (bool)($data['is_admin'] ?? false),
        ]);
        return redirect()->route('admin.users.index')->with('ok','User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('ok','User deleted');
    }

    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = !$user->is_admin;
        $user->save();
        return back()->with('ok','Role toggled');
    }
}
