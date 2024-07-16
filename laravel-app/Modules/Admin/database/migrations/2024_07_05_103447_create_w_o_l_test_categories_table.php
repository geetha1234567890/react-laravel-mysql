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
        Schema::create('wol_test_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wol_test_config_id');
            $table->unsignedBigInteger('wol_category_id');
            $table->unsignedBigInteger('number_of_questions');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('wol_test_config_id', 'fk_testconfig_testcategory')
            ->references('id')->on('wol_test_configs')->onDelete('cascade');
            $table->foreign('wol_category_id', 'fk_test_config__category')
            ->references('id')->on('wol_category')->onDelete('cascade');
            $table->foreign('created_by', 'fk_test_category_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_test_category_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wol_test_categories');
    }
};
