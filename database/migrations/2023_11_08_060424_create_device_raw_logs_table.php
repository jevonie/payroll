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
        Schema::create('device_raw_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('state');
            $table->date('attendance_date')->nullable();
            $table->time('attendance_time')->nullable();
            $table->integer('status');
            $table->integer('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_raw_logs');
    }
};
