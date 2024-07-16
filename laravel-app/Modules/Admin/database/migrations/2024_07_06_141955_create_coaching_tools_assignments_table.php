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
        Schema::create('coaching_tools_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coaching_tool_id');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('assignable_id');
            $table->string('assignable_type'); // 'Student' or 'Batch'
            $table->timestamps();

            $table->foreign('coaching_tool_id')->references('id')->on('coaching_tools');
            $table->foreign('activity_id')->references('id')->on('coaching_template_module_activities');
            $table->index(['assignable_id', 'assignable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_tools_assignments');
    }
};
