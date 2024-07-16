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
        Schema::create('wol_option_configs', function (Blueprint $table) {
            $table->id();
            $table->string('minimum_scale')->nullable(false);
            $table->string('maximum_scale')->nullable(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns
            // Define foreign key with unique constraint names
            $table->foreign('created_by', 'fk_option_configs_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_option_configs_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_o_l_option_configs');
    }
};
