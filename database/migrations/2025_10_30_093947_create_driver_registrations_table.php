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
        Schema::create('driver_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('license_type', ['car', 'motorcycle']);
            $table->string('test_center');
            $table->date('test_date');
            $table->string('national_id');    // store file path
            $table->string('photo');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_registrations');
    }
};
