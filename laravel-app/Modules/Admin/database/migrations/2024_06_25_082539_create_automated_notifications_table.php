<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('automated_notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('notification_type', ['SMS', 'Email', 'WhatsApp']);
            $table->text('content')->nullable();
            $table->string('recipient')->nullable();
            $table->string('message')->nullable();
            $table->timestamp('date_sent')->useCurrent();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automated_notifications');
    }
};
