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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('name');
            $table->string('value');
            $table->string('type');
            $table->string('wage_type');
            $table->string('info_type');
            $table->foreignId('expense_category')->constrained('expense_categories')->onDelete('cascade');
            $table->string('amount_per_kilometer')->nullable();
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
        Schema::dropIfExists('expenses');
    }
};
