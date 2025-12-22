<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserAdminController extends Controller
{
    public function usersindex()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('componentsAdmin.add-user-modal');
    }

    public function store(Request $request) 
    {
        User::create([
            'email' => $request->email,       
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users'); 
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('componentsAdmin.edit-user-modal', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        // Hanya update password jika admin mengisi field password
        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $users->update($data);

        return redirect()->route('admin.users');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.users');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);

        // Update user status to active
        $user->update(['status' => 'active']);

        return redirect()->route('admin.users')->with('success', 'User has been unblocked successfully.');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('admin.users', compact('users'));
    }

}