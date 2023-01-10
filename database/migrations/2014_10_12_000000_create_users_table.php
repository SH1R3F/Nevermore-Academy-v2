<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile');
            $table->integer('mobile_verification_code')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->integer('two_fa_code')->nullable();
            $table->timestamp('two_fa_expires_at')->nullable();
            $table->string('password');
            $table->string('fcm_token')->nullable();
            $table->point('location')->default(DB::raw("(ST_GeomFromText('POINT(27.661024 37.959821)'))")); // Saudi arabia
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
