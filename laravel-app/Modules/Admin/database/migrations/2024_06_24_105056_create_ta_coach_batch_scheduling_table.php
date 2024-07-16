<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ta_coach_batch_scheduling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ta_schedule_id');
            $table->unsignedBigInteger('batch_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->foreign('ta_schedule_id')->references('id')->on('ta_coach_scheduling')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ta_coach_batch_scheduling');
    }
};

