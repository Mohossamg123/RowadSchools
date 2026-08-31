<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'language' => $this->language,
            'status' => $this->status,
            'last_login_at' => $this->last_login_at,

            'roles' => RoleResource::collection(
                $this->whenLoaded('roles')
            ),
        ];
    }
}
