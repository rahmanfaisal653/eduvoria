<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAdmin;

class UserAdminController extends Controller
{
    public function usersindex()
    {
        // PERBAIKAN 1: Samakan nama variabel ($users) dengan compact
        $users = UserAdmin::all();
        return view('admin.users', compact('users'));
    }

    public function create()
    {
        return view('componentsAdmin.add-user-modal');
    }

    public function store(Request $request) 
    {
        UserAdmin::create([
            'email' => $request->email,       
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users'); 
    }

    public function edit($id)
    {
        $users = UserAdmin::findOrFail($id);
        return view('componentsAdmin.edit-user-modal', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $users = UserAdmin::findOrFail($id);
        $users->update([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users');
    }

    public function destroy($id)
    {
        $users = UserAdmin::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.users');
    }
}