<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignmentsManagementTest extends TestCase
{
    /**
     * Unauthorized user cannot enter assignments index page
     *
     * @return void
     */
    public function test_unauthorized_user_cannot_enter_assignments_index()
    {
        $user = User::factory()->create(['role_id' => null]); // Someone has no role

        $response = $this->actingAs($user)->get(route('assignments.index'));

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Authorized user can enter assignments index page
     *
     * @return void
     */
    public function test_authorized_user_can_enter_assignments_index()
    {
        $user = User::factory()->create(); // A student to be given permission

        // Giving permission
        $user->role->setPermissionsBySlugs(['viewAny-assignment']);

        $response = $this->actingAs($user)->get(route('assignments.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * Superadmin can do whatever he wants no matter what permissions he has!
     *
     * @return void
     */
    public function test_superadmin_can_enter_assignments_without_permission()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $response = $this->actingAs($user)->get(route('assignments.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * A teacher can only delete his assignments
     *
     * @return void
     */
    public function test_teacher_can_only_delete_his_assignments()
    {
        $teacher = User::factory()->create(['role_id' => 2]); // A teacher
        $assignment = Assignment::factory()->create(['teacher_id' => $teacher->id]); // Assignment by our teacher
        $assignment2 = Assignment::factory()->create(); // Assignment by new teacher

        $response = $this->actingAs($teacher)->delete(route('assignments.destroy', $assignment->id)); // deleting his assignment
        $response2 = $this->actingAs($teacher)->delete(route('assignments.destroy', $assignment2->id)); // deleting not his assignment

        $response->assertStatus(302); // success and redirected 
        $response2->assertStatus(403); // Forbidden
    }

    /**
     * A teacher can only edit his assignments
     *
     * @return void
     */
    public function test_teacher_can_only_edit_his_assignments()
    {
        $teacher = User::factory()->create(['role_id' => 2]); // A teacher
        $assignment = Assignment::factory()->create(['teacher_id' => $teacher->id]); // Assignment by our teacher
        $assignment2 = Assignment::factory()->create(); // Assignment by new teacher

        $response = $this->actingAs($teacher)->put(route('assignments.update', $assignment->id), [
            'title' => 'ay 7aga',
            'requirement' => 'asdjkahsd',
            'deadline' => Carbon::tomorrow()
        ]); // editing his assignment
        $response2 = $this->actingAs($teacher)->put(route('assignments.update', $assignment2->id), [
            'title' => 'ay 7aga',
            'requirement' => 'asdjkahsd',
            'deadline' => Carbon::tomorrow()
        ]); // editing not his assignment

        $response->assertStatus(302); // success and redirected 
        $response2->assertStatus(403); // Forbidden
    }

    /**
     * A teacher can only see his assignments
     *
     * @return void
     */
    public function test_teacher_can_only_see_his_assignments()
    {
        $teacher = User::factory()->create(['role_id' => 2]); // A teacher
        $assignment = Assignment::factory()->create(['teacher_id' => $teacher->id]); // Assignment by our teacher
        $assignment2 = Assignment::factory()->create(); // Assignment by new teacher

        $response = $this->actingAs($teacher)->get(route('assignments.show', $assignment->id)); // seeing his assignment
        $response2 = $this->actingAs($teacher)->get(route('assignments.show', $assignment2->id)); // seeing not his assignment

        $response->assertStatus(200); // success 
        $response2->assertStatus(403); // Forbidden
    }

    /**
     * A teacher can only degree a submission of his assignment
     *
     * @return void
     */
    public function test_teacher_can_only_degree_submission_of_his_assignments()
    {
        $teacher = User::factory()->create(['role_id' => 2]); // A teacher
        $assignment = Assignment::factory()->create(['teacher_id' => $teacher->id]); // Assignment by our teacher
        $submission = Submission::factory()->create(['assignment_id' => $assignment->id]); // Submission for our teacher's assignment
        $submission2 = Submission::factory()->create(); // Submission by new teacher assignment


        $response = $this->actingAs($teacher)->get(route('submissions.update', $submission->id), ['degree' => 5]); // give degree for his assignment's submission
        $response2 = $this->actingAs($teacher)->get(route('submissions.update', $submission2->id), ['degree' => 5]); // give degree for not his assignment's submission

        $response->assertStatus(200); // success 
        $response2->assertStatus(403); // Forbidden
    }
}
