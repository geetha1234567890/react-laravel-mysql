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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id');
            $table->date('start_date'); // Start_date DATE [not null]
            $table->date('end_date'); // End_date DATE [not null]
            $table->time('start_time')->nullable(); // Start_Time TIME
            $table->time('end_time')->nullable(); // End_Time TIME
            $table->boolean('approve_status')->default(false); // ApproveStatus bool
            $table->enum('leave_type', ['full', 'half']); // Leave_type ENUM('full', 'half')
            $table->string('message')->nullable(); // Message varchar
            $table->timestamps(); // Created_at and updated_at timestamps

            
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
