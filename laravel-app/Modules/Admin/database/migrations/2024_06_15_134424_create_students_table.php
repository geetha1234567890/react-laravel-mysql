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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('student_lms_id')->nullable();
            $table->string('email')->nullable();
            $table->string('academic_term')->nullable();
            $table->string('class_id')->nullable();
            $table->string('board_id')->nullable();
            $table->string('stream_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('primary_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
