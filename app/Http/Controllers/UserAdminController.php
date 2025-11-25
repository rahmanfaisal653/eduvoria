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
        $users->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.users');
    }
}