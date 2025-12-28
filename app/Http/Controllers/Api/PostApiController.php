<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PostApiController extends Controller
{
    /**
     * Display a listing of posts
     * GET /api/posts
     */
    public function index(Request $request)
    {
        $query = Post::with('user')
            ->withCount('replies')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc');

        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $posts = $query->paginate($perPage);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created post
     * POST /api/posts
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'content' => 'required|string|max:5000',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('posts', 'public');
            }

            $post = Post::create([
                'user_id' => Auth::id(),
                'content' => $validated['content'],
                'image' => $imagePath,
                'likes_count' => 0,
                'views' => 0,
                'bookmarks_count' => 0,
                'status' => 'active'
            ]);

            // Load relationships
            $post->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dibuat',
                'data' => new PostResource($post)
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
     * Display the specified post
     * GET /api/posts/{id}
     */
    public function show($id)
    {
        $post = Post::with('user')
            ->withCount('replies')
            ->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan'
            ], 404);
        }

        // Increment view count if user is logged in and not the owner
        if (Auth::check() && Auth::id() !== $post->user_id) {
            $post->increment('views');
        }

        return response()->json([
            'success' => true,
            'data' => new PostResource($post)
        ], 200);
    }

    /**
     * Update the specified post
     * PUT/PATCH /api/posts/{id}
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan'
            ], 404);
        }

        // Check if user owns this post
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengupdate post ini'
            ], 403);
        }

        try {
            $validated = $request->validate([
                'content' => 'required|string|max:5000',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $post->image = $request->file('image')->store('posts', 'public');
            }

            $post->content = $validated['content'];
            $post->save();

            // Load relationships
            $post->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Post berhasil diupdate',
                'data' => new PostResource($post)
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
     * Remove the specified post
     * DELETE /api/posts/{id}
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan'
            ], 404);
        }

        // Check if user owns this post
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk menghapus post ini'
            ], 403);
        }

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus'
        ], 200);
    }
}
