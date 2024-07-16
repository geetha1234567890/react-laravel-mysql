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
        Schema::create('wol_option_config_scale_wises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('point')->nullable();
            $table->string('text')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('wol_option_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns
            // Define foreign key with unique constraint names
            $table->foreign('wol_option_id', 'fk_option_configs_scale_config_option')
            ->references('id')->on('wol_option_configs')->onDelete('cascade');
            $table->foreign('created_by', 'fk_option_configs_scale_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_option_configs_scale_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wol_option_config_scale_wises');
    }
};
