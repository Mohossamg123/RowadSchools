<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'platform' => $this->platform,

            'username' => $this->username,

            'url' => $this->url,

            'status' => $this->status,

            'has_token' => !empty($this->access_token),

            'last_synced_at' => $this->last_synced_at,

            'posts' => SocialMediaPostResource::collection(
                $this->whenLoaded('posts')
            ),
        ];
    }
}
