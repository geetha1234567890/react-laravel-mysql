<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email',80)->unique();
            $table->string('phone',15)->unique();
            $table->string('password');
            $table->string('location');
            $table->string('address', 255);
            $table->string('pincode', 6);
            $table->string('time_zone');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth');
            $table->string('highest_qualification');
            $table->binary('profile_picture')->nullable();
            $table->text('profile')->nullable();
            $table->text('about_me')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        // Insert default admin user
        DB::table('admin_users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin123',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('123'), // Replace 'password' with your secure default password
            'location' => 'Head Office',
            'address' => '123 Admin Street',
            'pincode' => '123456',
            'time_zone' => 'Asia/Kolkata',
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'highest_qualification' => 'Default'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
