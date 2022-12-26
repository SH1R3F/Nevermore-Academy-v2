<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Assignment;
use App\Traits\FileUploads;
use Illuminate\Support\Facades\Auth;

class SubmissionService
{
    use FileUploads;

    public function store(array $data, Assignment $assignment): void
    {
        // Upload file
        $data['file'] = $this->upload($data['file'], "submissions/{$assignment->id}/");
        // Student id
        $data['student_id'] = Auth::user()->id; // I think there's something else like create()->for(Auth::user())??

        $assignment->submissions()->create($data);
    }
}
