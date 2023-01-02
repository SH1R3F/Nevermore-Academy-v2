<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'title' => $this->title,
            'requirement' => $this->requirement,
            'deadline' => $this->deadline,
            'teacher_id' => $this->teacher_id,
            'teacher' => new UserResource($this->whenLoaded('teacher')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'viewable' => $user->can('view', $this->resource),
            'editable' => $user->can('update', $this->resource),
            'deleteable' => $user->can('delete', $this->resource),
            'submitable' => $user->can('create', [Submission::class, $this->resource]),
        ];
    }
}
