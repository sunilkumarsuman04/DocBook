<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_profiles', 'max_patients_per_day')) {
                $table->unsignedInteger('max_patients_per_day')->default(30)->after('max_tokens');
            }
            if (!Schema::hasColumn('doctor_profiles', 'allow_next_day')) {
                $table->boolean('allow_next_day')->default(true)->after('max_patients_per_day');
            }
            if (!Schema::hasColumn('doctor_profiles', 'doctor_image')) {
                $table->string('doctor_image')->nullable()->after('allow_next_day');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropColumn(['max_patients_per_day', 'allow_next_day', 'doctor_image']);
        });
    }
};
