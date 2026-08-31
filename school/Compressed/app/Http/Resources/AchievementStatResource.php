<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IconResolver;

class AchievementStatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'icon' => IconResolver::resolve($this->icon),
            'value' => $this->value,
            'label' => $this->label,
            'note' => $this->note,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}
