<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'platform' => $this->platform,
            'mediaUrl' => $this->media_url,
            'embedUrl' => $this->embed_url,
            'linkUrl' => $this->link_url,
        ];
    }
}
