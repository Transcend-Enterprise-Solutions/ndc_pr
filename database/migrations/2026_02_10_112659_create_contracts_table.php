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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_id')->constrained()->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->string('supplier_name');
            $table->string('supplier_tin');
            $table->text('supplier_address');
            $table->decimal('contract_amount', 15, 2);
            $table->date('contract_date');
            $table->date('delivery_date');
            $table->integer('delivery_days');
            $table->enum('status', ['executed', 'ongoing', 'completed', 'terminated'])->default('executed');
            $table->text('terms_and_conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
