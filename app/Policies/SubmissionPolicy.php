<?php

namespace App\Policies;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @param  \App\Models\Submission|string  $submission
     * @return void|bool
     */
    public function before(User $user, $ability, $submission)
    {
        // We don't want to return false if not superadmin
        if ($user->hasRole('superadmin')) return true;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('viewAny-submission');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Assignment $assignment)
    {
        if (!$assignment->submissions()->where('student_id', $user->id)->count()) return Response::denyWithStatus(404);

        return $user->hasPermission('view-submission');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Assignment $assignment)
    {
        // Carefull assignment deadline

        return $user->hasPermission('create-submission') && $assignment->deadline >= Carbon::now();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Submission $submission)
    {
        // Submission must be for one of his assignments     
        return $user->hasPermission('update-submission') && $user->assignments->contains('id', $submission->assignment_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Submission $submission)
    {
        return $user->hasPermission('delete-submission');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Submission $submission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Submission $submission)
    {
        //
    }
}
