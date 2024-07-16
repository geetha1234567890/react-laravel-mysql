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
        Schema::create('coach_tem_mod_act_prerequisites', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing ID
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('template_id');
            $table->dateTime('lock_until_date');
            $table->time('time');
            $table->boolean('is_locked');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes(); // This will add deleted_at columns
            $table->timestamps(); // This will add created_at and updated_at columns

            $table->foreign('module_id')->references('id')->on('coaching_template_modules')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('coaching_template_module_activities')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('coaching_templates')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_tem_mod_act_prerequisites');
    }
};
