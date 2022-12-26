<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionManagementTest extends TestCase
{
    /**
     * Student cannot submit twice for assignment
     *
     * @return void
     */
    public function test_student_cannot_submit_twice_for_assignment()
    {
        $student = User::factory()->create(['role_id' => 3]); // A student
        $assignment = Assignment::factory()->create(['deadline' => Carbon::tomorrow()]); // Assignment
        $submission = Submission::factory()->create(['assignment_id' => $assignment->id, 'student_id' => $student->id]); // submission already created

        $response = $this->actingAs($student)->post(route('submissions.store', $assignment->id), [
            'message' => 'ay 7aga',
            'file' => UploadedFile::fake()->create('document.pdf', 1000)
        ]); // Submit submission

        $response->assertSessionHas('status', 'You already submitted once');
    }

    /**
     * Student can submit for assignment
     *
     * @return void
     */
    public function test_student_can_submit_for_assignment()
    {
        $student = User::factory()->create(['role_id' => 3]); // A student
        $assignment = Assignment::factory()->create(['deadline' => Carbon::tomorrow()]); // Assignment

        $response = $this->actingAs($student)->post(route('submissions.store', $assignment->id), [
            'message' => 'ay 7aga',
            'file' => UploadedFile::fake()->create('document.pdf', 1000)
        ]); // Submit submission
        $response->assertSessionHas('status', 'Submission saved successfully');
    }

    /**
     * Notification is pushed to database when teacher degree student's submission
     *
     * @return void
     */
    public function test_notification_is_pushed_when_submission_degreed()
    {
        $teacher = User::factory()->create(['role_id' => 2]); // A teacher
        $assignment = Assignment::factory()->create(['deadline' => Carbon::tomorrow(), 'teacher_id' => $teacher->id]); // Assignment
        $submission = Submission::factory()->create(['assignment_id' => $assignment->id]); // submission 


        $response = $this->actingAs($teacher)->put(route('submissions.update', $submission->id), [
            'degree' => 5
        ]); // Submit submission

        $this->assertDatabaseHas('notifications', ['notifiable_id' => $submission->student_id]);
    }
}
