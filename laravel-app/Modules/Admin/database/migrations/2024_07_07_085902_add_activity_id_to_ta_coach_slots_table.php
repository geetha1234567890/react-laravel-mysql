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
        Schema::table('ta_coach_slots', function (Blueprint $table) {
            // Add a new column 'activity_id' after 'admin_user_id'
            $table->unsignedBigInteger('activity_id')->after('admin_user_id')->nullable();

            // Create a foreign key constraint on 'activity_id'
            $table->foreign('activity_id')
                  ->references('id')
                  ->on('coaching_template_module_activities')
                  ->onDelete('restrict'); // Define onDelete behavior if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ta_coach_slots', function (Blueprint $table) {
            $table->dropColumn('activity_id');
        });
    }
};
