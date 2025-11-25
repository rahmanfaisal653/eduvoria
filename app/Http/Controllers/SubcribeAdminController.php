<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;

class SubcribeAdminController extends Controller
{
    public function reportsSubscribeIndex()
    {
        $subscribe = Subscribe::all();
        return view('admin.subscribe', compact('subscribe'));
    }

    public function destroy($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();

        return redirect()->route('admin.subscribe');
    }

    public function edit($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        return view('componentsAdmin.edit-subscribe-modal', compact('subscribe'));
    }

    public function update(Request $request, $id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscribe');
    }

    public function create()
    {
        return view('componentsAdmin.add-subscribe-modal');
    }

    public function store(Request $request)
    {
        Subscribe::create([
            'useraname' => $request->username,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.subscribe');
    }
}
