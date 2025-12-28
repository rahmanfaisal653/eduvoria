<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture ? asset('storage/' . $this->profile_picture) : null,
            'bio' => $this->bio,
            'hobi' => $this->hobi,
            'role' => $this->role,
            'status' => $this->status,
            'followers_count' => $this->followers_count ?? 0,
            'following_count' => $this->following_count ?? 0,
            'is_subscribed' => $this->isSubscribed(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
