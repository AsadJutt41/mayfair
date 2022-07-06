<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('designation')->nullable();
            $table->string('role')->nullable();
            $table->string('user_type')->nullable();
            $table->string('line_manager')->nullable();
            $table->string('over_limit_approver')->nullable();
            $table->string('phone_number');
            $table->string('sap_id')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('base_town')->nullable();
            $table->string('zone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
