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
        Schema::create('coaching_template_module_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('activity_type_id')->nullable();
            $table->text('activity_url')->nullable();
            $table->string('activity_name');
            $table->date('due_date');
            $table->integer('points');
            $table->date('after_due_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes(); // Adds deleted_at column
            $table->timestamps(); // Adds created_at and updated_at columns

            // Foreign key constraints
            $table->foreign('module_id')->references('id')->on('coaching_template_modules')->onDelete('cascade');
            $table->foreign('activity_type_id')->references('id')->on('coaching_template_activity_types')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_template_module_activities');
    }
};
