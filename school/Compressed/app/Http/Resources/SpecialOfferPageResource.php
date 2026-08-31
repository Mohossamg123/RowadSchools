<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialOfferPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'slug' => $this->slug,

            'description' => $this->description,

            'is_active' => $this->is_active,

            'seo' => [
                'noindex' => $this->noindex,
                'nofollow' => $this->nofollow,
            ],

            'robots' => trim(
                ($this->noindex ? 'noindex' : 'index')
                . ','
                . ($this->nofollow ? 'nofollow' : 'follow')
            ),

            'images' => SpecialOfferPageImageResource::collection(
                $this->whenLoaded('images')
            ),
        ];
    }
}
