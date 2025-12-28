<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentUser = Auth::user();
        
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'content' => $this->content,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'likes_count' => $this->likes_count ?? 0,
            'views' => $this->views ?? 0,
            'bookmarks_count' => $this->bookmarks_count ?? 0,
            'replies_count' => $this->whenCounted('replies'),
            'status' => $this->status,
            
            // Interaction status for current user
            'is_liked' => $currentUser ? $this->likes()->where('user_id', $currentUser->id)->exists() : false,
            'is_bookmarked' => $currentUser ? $this->bookmarks()->where('user_id', $currentUser->id)->exists() : false,
            'is_owner' => $currentUser ? $this->user_id === $currentUser->id : false,
            
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
