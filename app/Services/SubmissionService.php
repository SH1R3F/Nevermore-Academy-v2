<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Assignment;
use App\Models\Submission;
use App\Traits\FileUploads;
use App\Notifications\NewSubmission;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SubmissionDegreed;

class SubmissionService
{
    use FileUploads;

    public function store(array $data, Assignment $assignment): void
    {
        // Upload file
        $data['file'] = $this->upload($data['file'], "submissions/{$assignment->id}/");
        // Student id
        $data['student_id'] = Auth::user()->id; // I think there's something else like create()->for(Auth::user())??

        $submission = $assignment->submissions()->create($data);

        // Send notification to teacher.
        $assignment->teacher->notify(new NewSubmission($submission));
    }

    public function degreeSubmission(array $data, Submission $submission): void
    {
        $submission->update($data);

        // Notify student that his assignment has degreed
        $submission->student->notify(new SubmissionDegreed($submission));
    }
}
