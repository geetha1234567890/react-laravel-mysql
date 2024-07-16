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
        Schema::create('wol_test_config_with_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('wol_question_id');
            $table->unsignedBigInteger('wol_test_category_id');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns

            $table->foreign('wol_test_category_id', 'fk_test_category_id')
            ->references('id')->on('wol_test_categories')->onDelete('cascade');

            $table->foreign('wol_question_id', 'fk_test_question_question')
            ->references('id')->on('wol_questions')->onDelete('cascade');
            $table->foreign('created_by', 'fk_test_question_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_est_question_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wol_test_config_with_questions');
    }
};
