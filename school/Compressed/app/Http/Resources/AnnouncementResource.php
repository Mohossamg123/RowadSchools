<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'image' => $this->image,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}
