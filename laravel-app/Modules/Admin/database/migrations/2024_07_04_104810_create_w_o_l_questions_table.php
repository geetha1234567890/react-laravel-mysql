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
        Schema::create('wol_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question')->nullable(false);
            $table->unsignedBigInteger('wol_category_id');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns

            // Define foreign key with unique constraint names
            $table->foreign('wol_category_id', 'fk_questions1_category')
            ->references('id')->on('wol_category')->onDelete('cascade');
            $table->foreign('created_by', 'fk_questions_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_questions_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wol_questions');
    }
};
