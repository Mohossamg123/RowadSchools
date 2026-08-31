<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IconResolver;

class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => IconResolver::resolve($this->icon),
            'description' => $this->description,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
        ];
    }
}
