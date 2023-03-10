<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create the basic roles that must be implemented.
        Permission::create(['slug' => 'viewAny-role']);
        Permission::create(['slug' => 'view-role']);
        Permission::create(['slug' => 'create-role']);
        Permission::create(['slug' => 'update-role']);
        Permission::create(['slug' => 'delete-role']);
        // Users
        Permission::create(['slug' => 'viewAny-user']);
        Permission::create(['slug' => 'view-user']);
        Permission::create(['slug' => 'create-user']);
        Permission::create(['slug' => 'update-user']);
        Permission::create(['slug' => 'delete-user']);
        // Assignments
        Permission::create(['slug' => 'viewAny-assignment']);
        Permission::create(['slug' => 'view-assignment']);
        Permission::create(['slug' => 'create-assignment']);
        Permission::create(['slug' => 'update-assignment']);
        Permission::create(['slug' => 'delete-assignment']);
        // Submissions
        Permission::create(['slug' => 'viewAny-submission']);
        Permission::create(['slug' => 'view-submission']);
        Permission::create(['slug' => 'create-submission']);
        Permission::create(['slug' => 'update-submission']);
        Permission::create(['slug' => 'delete-submission']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
