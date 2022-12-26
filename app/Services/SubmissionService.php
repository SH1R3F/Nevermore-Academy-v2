<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Assignment;
use App\Models\Submission;
use App\Notifications\SubmissionDegreed;
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

    public function degreeSubmission(array $data, Submission $submission): void
    {
        $submission->update($data);

        // Notify student that his assignment has degreed
        $submission->student->notify(new SubmissionDegreed($submission));
    }
}
