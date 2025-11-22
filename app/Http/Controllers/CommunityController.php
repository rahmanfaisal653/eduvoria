<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CommunityPost;
use App\Models\CommunityEvent;

class CommunityController extends Controller
{
   
    public function index()
    {
        $communities = Community::orderBy('id', 'DESC')->get();

        $suggestedGroups = [];
        $upcomingEvents  = [];

        return view('users.komunitas.komunitas', compact(
            'communities',
            'suggestedGroups',
            'upcomingEvents'
        ));
    }

    public function create()
    {
        return view('users.komunitas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required',
            'description'       => 'nullable',
            'category'          => 'nullable',
            'profile_image'     => 'nullable|image|mimes:jpg,jpeg,png',
            'background_image'  => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

       
        $uploadPath = public_path('uploads/komunitas');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        
        if ($request->hasFile('profile_image')) {
            $profileName = time().'_'.$request->profile_image->getClientOriginalName();
            $request->profile_image->move($uploadPath, $profileName);
            $data['profile_image'] = $profileName;
        }

       
        if ($request->hasFile('background_image')) {
            $bgName = time().'_'.$request->background_image->getClientOriginalName();
            $request->background_image->move($uploadPath, $bgName);
            $data['background_image'] = $bgName;
        }

       
        $data['slug'] = Str::slug($data['name']);
        $data['owner_id'] = 1;        
        $data['members_count'] = 1;

        Community::create($data);

        return redirect()->route('komunitas.index')->with('success', 'Komunitas berhasil dibuat.');
    }

public function show($id)
{
    $community = Community::findOrFail($id);

    $posts = CommunityPost::where('community_id', $community->id)
                ->orderBy('created_at', 'desc')
                ->get();

    $events = CommunityEvent::where('community_id', $community->id)
                ->orderBy('event_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

    return view('users.komunitas.komunitasdiskusi', compact('community', 'posts', 'events'));
}

    
    public function edit($id)
    {
        $community = Community::findOrFail($id);

        return view('users.komunitas.edit', compact('community'));
    }

    public function update(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        $data = $request->validate([
            'name'              => 'required',
            'description'       => 'nullable',
            'category'          => 'nullable',
            'profile_image'     => 'nullable|image|mimes:jpg,jpeg,png',
            'background_image'  => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $uploadPath = public_path('uploads/komunitas');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        
        if ($request->hasFile('profile_image')) {
            $profile = time().'_'.$request->profile_image->getClientOriginalName();
            $request->profile_image->move($uploadPath, $profile);
            $data['profile_image'] = $profile;
        }

        if ($request->hasFile('background_image')) {
            $bg = time().'_'.$request->background_image->getClientOriginalName();
            $request->background_image->move($uploadPath, $bg);
            $data['background_image'] = $bg;
        }

        $data['slug'] = Str::slug($data['name']);

        $community->update($data);

        return redirect()->route('komunitas.index')->with('success', 'Komunitas berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $community = Community::findOrFail($id);

        $community->delete();

        return redirect()->route('komunitas.index')->with('success', 'Komunitas berhasil dihapus.');
    }

}
