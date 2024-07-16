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
        Schema::create('coach_templ_activity_dependencies', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing ID
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('prerequisite_id');
            $table->unsignedBigInteger('activity_id');
            $table->string('dependency_type');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes(); // This will add deleted_at columns
            $table->timestamps(); // This will add created_at and updated_at columns

            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            $table->foreign('prerequisite_id')->references('id')->on('coach_tem_mod_act_prerequisites')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('coaching_template_module_activities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_templ_activity_dependencies');
    }
};
