<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'external_id' => $this->external_id,

            'content' => $this->content,

            'post_url' => $this->post_url,

            'media_url' => $this->media_url,

            'published_at' => $this->published_at,

            'status' => $this->status,
        ];
    }
}
