<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesManagementTest extends TestCase
{
    /**
     * Unauthorized user cannot enter roles index page
     *
     * @return void
     */
    public function test_unauthorized_user_cannot_enter_roles_index()
    {
        $user = User::factory()->create(); // A student

        $response = $this->actingAs($user)->get(route('roles.index'));

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Authorized user can enter roles index page
     *
     * @return void
     */
    public function test_authorized_user_can_enter_roles_index()
    {
        $user = User::factory()->create(); // A student to be given permission

        // Giving permission
        $user->role->setPermissionsBySlugs(['viewAny-role']);

        $response = $this->actingAs($user)->get(route('roles.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * Superadmin can do whatever he wants no matter what permissions he has!
     *
     * @return void
     */
    public function test_superadmin_can_enter_roles_without_permission()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $response = $this->actingAs($user)->get(route('roles.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * Superadmin, Teacher, and Student roles can never be deleted
     *
     * @return void
     */
    public function test_superadmin_teacher_student_roles_cannot_be_deleted()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $response_superadmin = $this->actingAs($user)->delete(route('roles.destroy', 1)); // Delete superadmin
        $response_teacher = $this->actingAs($user)->delete(route('roles.destroy', 2)); // Delete teacher
        $response_student = $this->actingAs($user)->delete(route('roles.destroy', 3)); // Delete student

        $response_superadmin->assertStatus(403); // Forbidden
        $response_teacher->assertStatus(403); // Forbidden
        $response_student->assertStatus(403); // Forbidden
    }

    /**
     * Other roles can be deleted
     *
     * @return void
     */
    public function test_other_roles_can_be_deleted()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $role = Role::create(['name' => 'ay 7aga']);

        $response = $this->actingAs($user)->delete(route('roles.destroy', $role->id)); // Delete student

        $response->assertStatus(302); // Success and redirected
    }

    /**
     * Superadmin, Teacher, and Student role names can never be edited
     *
     * @return void
     */
    public function test_superadmin_teacher_student_role_names_cannot_be_edited()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $response_superadmin = $this->actingAs($user)->put(route('roles.update', 1), [
            'name' => 'ay 7aga'
        ]); // update superadmin
        $response_teacher = $this->actingAs($user)->put(route('roles.update', 2), [
            'name' => 'ay 7aga'
        ]); // update teacher
        $response_student = $this->actingAs($user)->put(route('roles.update', 3), [
            'name' => 'ay 7aga'
        ]); // update student

        $response_superadmin->assertStatus(302); // Redirected but not changed
        $this->assertEquals('superadmin', Role::find(1)->name);

        $response_teacher->assertStatus(302); // Redirected but not changed
        $this->assertEquals('teacher', Role::find(2)->name);

        $response_student->assertStatus(302); // Redirected but not changed
        $this->assertEquals('student', Role::find(3)->name);
    }


    /**
     * Other role names can be edited
     *
     * @return void
     */
    public function test_other_role_names_can_be_edited()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $role = Role::create(['name' => 'ay 7aga']);
        $new_name = 'Name changed';

        $response_superadmin = $this->actingAs($user)->put(route('roles.update', $role->id), [
            'name' => $new_name
        ]);

        $response_superadmin->assertStatus(302); // Redirected and changed
        $this->assertEquals($new_name, Role::find($role->id)->name);
    }
}
