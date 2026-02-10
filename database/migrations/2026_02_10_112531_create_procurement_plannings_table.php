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
        Schema::create('procurement_plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->string('item_description');
            $table->decimal('estimated_budget', 15, 2);
            $table->integer('quantity');
            $table->string('unit_of_measure');
            $table->date('target_procurement_date');
            $table->enum('procurement_mode', [
                'public_bidding',
                'limited_source_bidding',
                'direct_contracting',
                'repeat_order',
                'shopping',
                'negotiated_procurement'
            ]);
            $table->enum('status', ['planned', 'approved', 'cancelled'])->default('planned');
            $table->text('justification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_plannings');
    }
};
