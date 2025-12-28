<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserManagementApiController extends Controller
{
    /**
     * Ensure only admin can access these endpoints
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of users
     * GET /api/admin/users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $users = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created user
     * POST /api/admin/users
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'nullable|in:user,admin',
                'status' => 'nullable|in:active,blocked',
                'bio' => 'nullable|string|max:500',
                'hobi' => 'nullable|string|max:255',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'] ?? 'user',
                'status' => $validated['status'] ?? 'active',
                'bio' => $validated['bio'] ?? null,
                'hobi' => $validated['hobi'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => new UserResource($user)
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
     * Display the specified user
     * GET /api/admin/users/{id}
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Update the specified user
     * PUT/PATCH /api/admin/users/{id}
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8',
                'role' => 'nullable|in:user,admin',
                'status' => 'nullable|in:active,blocked',
                'bio' => 'nullable|string|max:500',
                'hobi' => 'nullable|string|max:255',
            ]);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'] ?? $user->role,
                'status' => $validated['status'] ?? $user->status,
                'bio' => $validated['bio'] ?? $user->bio,
                'hobi' => $validated['hobi'] ?? $user->hobi,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => new UserResource($user)
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
     * Remove the specified user
     * DELETE /api/admin/users/{id}
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ], 200);
    }

    /**
     * Block a user
     * POST /api/admin/users/{id}/block
     */
    public function block($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        // Prevent admin from blocking themselves
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat memblokir akun Anda sendiri'
            ], 403);
        }

        $user->update(['status' => 'blocked']);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diblokir',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Unblock a user
     * POST /api/admin/users/{id}/unblock
     */
    public function unblock($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->update(['status' => 'active']);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil di-unblock',
            'data' => new UserResource($user)
        ], 200);
    }

    /**
     * Get user statistics
     * GET /api/admin/users/stats
     */
    public function stats()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $blockedUsers = User::where('status', 'blocked')->count();
        $adminUsers = User::where('role', 'admin')->count();
        $subscribedUsers = User::whereHas('subscribe', function($query) {
            $query->where('status', 'paid')
                  ->where('expired_at', '>', now());
        })->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'active_users' => $activeUsers,
                'blocked_users' => $blockedUsers,
                'admin_users' => $adminUsers,
                'subscribed_users' => $subscribedUsers,
            ]
        ], 200);
    }
}
