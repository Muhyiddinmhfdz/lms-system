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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('path_thumbnail')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('category_course_id')->nullable();
            $table->foreignId('language_id')->nullable();
            $table->string('publisher')->nullable();
            $table->string('working_publisher')->nullable();
            $table->foreignId('level_id')->nullable();
            $table->double('duration', 12, 2);
            $table->double('price', 12, 2);
            $table->double('discount_price', 12, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
