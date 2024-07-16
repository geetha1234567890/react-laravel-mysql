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
        Schema::create('wol_life_instructions', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            //$table->timestamps(); // This will add the created_at and updated_at columns

            // Define foreign key with shorter constraint name
            $table->foreign('created_by', 'fk_created_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->foreign('updated_by', 'fk_updated_by')
            ->references('id')->on('admin_users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wol_life_instructions');
    }
};
