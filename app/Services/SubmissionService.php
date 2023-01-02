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

    public function store(array $data, Assignment $assignment): Submission
    {
        // Upload file
        $data['file'] = $this->upload($data['file'], "submissions/{$assignment->id}");
        // Student id
        $data['student_id'] = Auth::user()->id; // I think there's something else like create()->for(Auth::user())??

        $submission = $assignment->submissions()->create($data);

        // Send notification to teacher.
        $assignment->teacher->notify(new NewSubmission($submission));

        return $submission;
    }

    public function degreeSubmission(array $data, Submission $submission): void
    {
        $submission->update($data);

        // Notify student that his assignment has degreed
        $submission->student->notify(new SubmissionDegreed($submission));
    }

    public function userSubmittedBefore(Assignment $assignment): bool
    {
        // Is here a good place for this? Or should I put it inside policy?
        // This is dealing with the request I guess we shouldn't put inside a service
        // What about the return? it redirects the user so shouldn't the redirection be handled in the controller method itself?
        return !!$assignment->submissions()->where('student_id', Auth::user()->id)->count();
    }
}
