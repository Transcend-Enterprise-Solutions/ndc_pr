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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->string('dv_number')->unique();
            $table->date('dv_date');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_type', ['full', 'partial', 'advance', 'final']);
            $table->enum('status', ['pending', 'approved', 'for_release', 'released', 'cancelled'])->default('pending');
            $table->string('check_number')->nullable();
            $table->date('check_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
