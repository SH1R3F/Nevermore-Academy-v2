<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'avatar' => $this->getFirstMediaUrl('images'),
            'role_id' => $this->role_id,
            'role' => $this->role,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'editable' => $user->can('update', $this->resource),
            'deletable' => $user->can('delete', $this->resource)
        ];
    }
}
