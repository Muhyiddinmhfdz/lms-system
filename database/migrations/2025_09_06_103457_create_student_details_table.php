<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name')->nullable();
            $table->longText('address')->nullable();
            $table->longText('number_phone')->nullable();
            $table->enum('gender',['L', 'P'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->longText('place_of_birth')->nullable();
            $table->foreignId('education_id')->nullable();
            $table->foreignId('departement_id')->nullable();
            $table->string('path')->nullable();
            $table->string('path_profile')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
