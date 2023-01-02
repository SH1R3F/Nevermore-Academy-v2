<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AssignmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'file' => Storage::url($this->file),
            'degree' => $this->degree,
            'assignment_id' => $this->assignment_id,
            'assignment' => new AssignmentResource($this->whenLoaded('assignment')),
            'student_id' => $this->student_id,
            'student' => new UserResource($this->whenLoaded('student')),

            'viewable' => $request->user()->can('view', [Submission::class, $this->assignment]),
        ];
    }
}
