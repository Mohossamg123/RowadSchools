<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'gallery_id' => $this->gallery_id,
            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,
            'title' => $this->title,
            'alt' => $this->alt,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}
