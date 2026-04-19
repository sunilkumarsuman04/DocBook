<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the `otps` table for email-based OTP login.
     */
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();          // Email address linked to this OTP
            $table->string('otp', 6);                  // 6-digit OTP code
            $table->timestamp('expires_at');           // OTP expiry (5 minutes from creation)
            $table->timestamps();                      // created_at + updated_at

            // One OTP record per email — handled by updateOrCreate in controller
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};