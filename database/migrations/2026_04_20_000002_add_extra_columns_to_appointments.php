<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'is_extra_request')) {
                $table->boolean('is_extra_request')->default(false)->after('token_number');
            }
            if (!Schema::hasColumn('appointments', 'patient_note')) {
                $table->text('patient_note')->nullable()->after('is_extra_request');
            }
            if (!Schema::hasColumn('appointments', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('patient_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['is_extra_request', 'patient_note', 'approved_at']);
        });
    }
};
