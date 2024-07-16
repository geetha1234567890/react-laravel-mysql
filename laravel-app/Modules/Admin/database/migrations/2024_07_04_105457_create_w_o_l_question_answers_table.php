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
        Schema::create('wol_question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer')->nullable(false);
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('wol_category_id');
            $table->unsignedBigInteger('wol_questions_id');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns
            // Define foreign key with unique constraint names
            $table->foreign('student_id', 'fk_answers_student')
                ->references('id')->on('students')->onDelete('cascade');
            $table->foreign('wol_category_id', 'fk_answers_wol_category')
                ->references('id')->on('wol_category')->onDelete('cascade');
            $table->foreign('wol_questions_id', 'fk_wol_answer_question')
                ->references('id')->on('wol_questions')->onDelete('cascade');
            $table->foreign('created_by', 'fk_answers_created_by')
                ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_answers_updated_by')
                ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_o_l_question_answers');
    }
};
