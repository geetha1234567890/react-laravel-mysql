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
        Schema::create('coaching_template_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('assignable_id');
            $table->string('assignable_type'); // 'Student', 'Batch' or coach
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('coaching_tools');
            
           
            $table->index(['assignable_id', 'assignable_type'], 'idx_assignable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_template_assignments');
    }
};
