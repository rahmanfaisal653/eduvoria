<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use App\Models\CommunityMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CommunityApiController extends Controller
{
    /**
     * Display a listing of communities
     * GET /api/communities
     */
    public function index(Request $request)
    {
        $query = Community::with('owner')
            ->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $communities = $query->paginate($perPage);

        return CommunityResource::collection($communities);
    }

    /**
     * Store a newly created community
     * POST /api/communities
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user is subscribed or admin
        if (!$user->isAdmin() && !$user->isSubscribed()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu harus berlangganan terlebih dahulu untuk membuat komunitas.'
            ], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'nullable|string|max:255',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $validated;
            $data['slug'] = Str::slug($validated['name']);
            $data['owner_id'] = $user->id;
            $data['members_count'] = 1;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $filename = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->storeAs('komunitas', $filename, 'public');
                $data['profile_image'] = 'komunitas/' . $filename;
            }

            // Handle background image upload
            if ($request->hasFile('background_image')) {
                $filename = time() . '_bg_' . $request->file('background_image')->getClientOriginalName();
                $request->file('background_image')->storeAs('komunitas', $filename, 'public');
                $data['background_image'] = 'komunitas/' . $filename;
            }

            $community = Community::create($data);

            // Automatically add creator as member
            CommunityMember::create([
                'community_id' => $community->id,
                'user_id' => $user->id
            ]);

            // Load relationships
            $community->load('owner');

            return response()->json([
                'success' => true,
                'message' => 'Komunitas berhasil dibuat',
                'data' => new CommunityResource($community)
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified community
     * GET /api/communities/{id}
     */
    public function show($id)
    {
        $community = Community::with('owner')->find($id);

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Komunitas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CommunityResource($community)
        ], 200);
    }

    /**
     * Update the specified community
     * PUT/PATCH /api/communities/{id}
     */
    public function update(Request $request, $id)
    {
        $community = Community::find($id);

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Komunitas tidak ditemukan'
            ], 404);
        }

        $user = Auth::user();

        // Check authorization (owner or admin)
        if (!$user->isAdmin() && !($user->isSubscribed() && $community->owner_id === $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak punya akses untuk mengupdate komunitas ini'
            ], 403);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'nullable|string|max:255',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $validated;
            $data['slug'] = Str::slug($validated['name']);

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($community->profile_image) {
                    Storage::disk('public')->delete($community->profile_image);
                }
                $filename = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->storeAs('komunitas', $filename, 'public');
                $data['profile_image'] = 'komunitas/' . $filename;
            }

            // Handle background image upload
            if ($request->hasFile('background_image')) {
                // Delete old image if exists
                if ($community->background_image) {
                    Storage::disk('public')->delete($community->background_image);
                }
                $filename = time() . '_bg_' . $request->file('background_image')->getClientOriginalName();
                $request->file('background_image')->storeAs('komunitas', $filename, 'public');
                $data['background_image'] = 'komunitas/' . $filename;
            }

            $community->update($data);

            // Load relationships
            $community->load('owner');

            return response()->json([
                'success' => true,
                'message' => 'Komunitas berhasil diperbarui',
                'data' => new CommunityResource($community)
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified community
     * DELETE /api/communities/{id}
     */
    public function destroy($id)
    {
        $community = Community::find($id);

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Komunitas tidak ditemukan'
            ], 404);
        }

        $user = Auth::user();

        // Check authorization (owner or admin)
        if (!$user->isAdmin() && !($user->isSubscribed() && $community->owner_id === $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak punya akses untuk menghapus komunitas ini'
            ], 403);
        }

        // Delete images if exist
        if ($community->profile_image) {
            Storage::disk('public')->delete($community->profile_image);
        }
        if ($community->background_image) {
            Storage::disk('public')->delete($community->background_image);
        }

        $community->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komunitas berhasil dihapus'
        ], 200);
    }
}
