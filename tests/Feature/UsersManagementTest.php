<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersManagementTest extends TestCase
{
    /**
     * Unauthorized user cannot enter users index page
     *
     * @return void
     */
    public function test_unauthorized_user_cannot_enter_users_index()
    {
        $user = User::factory()->create(); // A student

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Authorized user can enter users index page
     *
     * @return void
     */
    public function test_authorized_user_can_enter_users_index()
    {
        $user = User::factory()->create(); // A student to be given permission

        // Giving permission
        $user->role->setPermissionsBySlugs(['viewAny-user']);

        $response = $this->actingAs($user)->get(route('users.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * Superadmin can do whatever he wants no matter what permissions he has!
     *
     * @return void
     */
    public function test_superadmin_can_enter_users_without_permission()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $response = $this->actingAs($user)->get(route('users.index'));
        $response->assertStatus(200); // Success
    }

    /**
     * Superadmin users can never be deleted
     *
     * @return void
     */
    public function test_superadmin_users_cannot_be_deleted()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin
        $user2 = User::factory()->create(['role_id' => 1]); // A superadmin

        $response = $this->actingAs($user)->delete(route('users.destroy', $user2->id)); // deleting a superadmin

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Other users can be deleted
     *
     * @return void
     */
    public function test_other_users_can_be_deleted()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $student = User::factory()->create(); // A student

        $response = $this->actingAs($user)->delete(route('users.destroy', $student->id)); // Delete student

        $response->assertStatus(302); // Success and redirected
    }

    /**
     * Superadmin users role can never be edited
     *
     * @return void
     */
    public function test_superadmin_user_role_cannot_be_edited()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $superadmin = User::factory()->create(['role_id' => 1]); // A superadmin


        $response = $this->actingAs($user)->put(route('users.update', $superadmin->id), [
            'role' => 2 // Teacher
        ]); // update superadmin

        $response->assertStatus(302); // Redirected but not changed
        $this->assertEquals(1, User::find($superadmin->id)->role_id);
    }


    /**
     * Other role user roles can be edited
     *
     * @return void
     */
    public function test_other_role_user_roles_can_be_edited()
    {
        $user = User::factory()->create(['role_id' => 1]); // A superadmin

        $student = User::factory()->create(['role_id' => 3]); // A student

        $response = $this->actingAs($user)->put(route('users.update', $student->id), [
            'name' => 'ay 7aga',
            'email' => 'ay-7aga@aa.dev',
            'role' => 2 // Teacher
        ]);

        $response->assertStatus(302); // Redirected and changed
        $this->assertEquals(2, User::find($student->id)->role_id);
    }
}
