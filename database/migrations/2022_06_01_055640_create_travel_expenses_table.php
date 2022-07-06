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
        Schema::create('travel_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('night_stay')->nullable();
            $table->string('travel_to')->nullable();
            $table->string('station')->nullable();
            $table->string('kilometer')->nullable();
            $table->string('fuel_amount')->nullable();
            $table->string('note')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('current_date')->nullable();
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
        Schema::dropIfExists('travel_expenses');
    }
};
