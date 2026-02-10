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
        Schema::create('monitoring_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->string('report_type'); // delivery, inspection, compliance
            $table->date('report_date');
            $table->decimal('percentage_completed', 5, 2)->default(0);
            $table->enum('status', ['on_track', 'delayed', 'at_risk', 'completed'])->default('on_track');
            $table->text('observations')->nullable();
            $table->text('issues')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('prepared_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_reports');
    }
};
