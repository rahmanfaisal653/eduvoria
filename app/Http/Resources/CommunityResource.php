<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CommunityResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => $this->category,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'owner_id' => $this->owner_id,
            'members_count' => $this->members_count ?? 0,
            'profile_image' => $this->profile_image ? asset('storage/' . $this->profile_image) : null,
            'background_image' => $this->background_image ? asset('storage/' . $this->background_image) : null,
            
            // Membership status for current user
            'is_member' => $currentUser ? $this->isMember($currentUser->id) : false,
            'is_owner' => $currentUser ? $this->owner_id === $currentUser->id : false,
            
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
