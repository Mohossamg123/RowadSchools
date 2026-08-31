<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IconResolver;

class HomepageFeatureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => IconResolver::resolve($this->icon),
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}
