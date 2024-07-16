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
        Schema::create('coaching_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps(); // This will add the created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_tools');
    }
};
