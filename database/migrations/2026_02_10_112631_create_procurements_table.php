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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_planning_id')->constrained()->onDelete('cascade');
            $table->string('pr_number')->unique();
            $table->date('pr_date');
            $table->string('purpose');
            $table->enum('status', [
                'draft',
                'for_approval',
                'approved',
                'for_bidding',
                'bid_evaluation',
                'awarded',
                'po_issued',
                'delivered',
                'completed',
                'cancelled'
            ])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurements');
    }
};
