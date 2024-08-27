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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_has_student_id');
            $table->timestamp('started_at')->default(now());
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['active', 'complete']);
            $table->integer('mark')->default(0);
            $table->timestamps();

            $table->foreign('course_has_student_id')->references('id')->on('course_has_students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
