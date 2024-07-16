<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ta_coach_scheduling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id');
            $table->string('meeting_name');
            $table->string('meeting_url');
            $table->dateTime('date');
            $table->unsignedBigInteger('slot_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('time_zone');
            $table->boolean('is_active')->default(true);
            $table->enum('event_status', ['scheduled', 'rescheduled', 'cancelled']);
            $table->unsignedBigInteger('series')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('ta_coach_slots')->onDelete('cascade');
            $table->foreign('series')->references('id')->on('ta_coach_scheduling')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ta_coach_schedulings');
    }
};