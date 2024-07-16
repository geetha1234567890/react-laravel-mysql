<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->timestamps();
        });
        DB::table('roles')->insert([
            ['role_name' => 'TA'],
            ['role_name' => 'Coach'],
            ['role_name' => 'Admin'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
