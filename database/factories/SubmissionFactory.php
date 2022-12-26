<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'message' => fake()->sentences(3, true),
            'file' => 'ay 7aga.pdf',
            'student_id' => User::factory()->create(['role_id' => 3])->id, // Student
            'assignment_id' => Assignment::factory()->create()->id
        ];
    }
}
