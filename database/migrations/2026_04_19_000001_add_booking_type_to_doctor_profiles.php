<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->enum('booking_type', ['time', 'token'])->default('time')->after('review_count');
            $table->unsignedInteger('max_tokens')->default(30)->after('booking_type');
        });
    }

    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn(['booking_type', 'max_tokens']);
        });
    }
};
