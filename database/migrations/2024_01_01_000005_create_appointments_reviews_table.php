<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('slot_id')->nullable()->constrained('slots')->nullOnDelete();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['PENDING','CONFIRMED','COMPLETED','CANCELLED','NO_SHOW'])->default('PENDING');
            $table->text('notes')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->enum('payment_status', ['UNPAID','PAID'])->default('UNPAID');
            $table->string('payment_method')->nullable();
            $table->boolean('is_reviewed')->default(false);
            $table->timestamps();

            $table->index(['patient_id', 'status']);
            $table->index(['doctor_id',  'status']);
            $table->index(['appointment_date']);
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('appointments');
    }
};
