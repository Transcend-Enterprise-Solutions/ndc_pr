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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_id')->constrained()->onDelete('cascade');
            $table->string('audit_number')->unique();
            $table->date('audit_date');
            $table->string('auditor_name');
            $table->enum('audit_type', ['pre_audit', 'post_audit', 'special_audit']);
            $table->enum('status', ['scheduled', 'ongoing', 'completed'])->default('scheduled');
            $table->text('findings')->nullable();
            $table->text('recommendations')->nullable();
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'partially_compliant'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
