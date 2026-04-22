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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('project_name')->nullable();
            $table->date('submitted_at');
            $table->string('due_date');
            $table->enum('status', ['draft','sent','partial','paid','overdue'])->default('draft');

            // Financials
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('completed_discount', 15, 2)->default(0);
            $table->string('completed_discount_label')->nullable();
            $table->decimal('proposed_discount', 15, 2)->default(0);
            $table->string('proposed_discount_label')->nullable();

            // Tax
            $table->boolean('tax_enabled')->default(false);
            $table->string('tax_label')->default('VAT');
            $table->decimal('tax_rate', 5, 2)->default(7.50);
            $table->enum('tax_applies_to', ['completed','proposed','both'])->default('completed');

            // WHT
            $table->boolean('wht_enabled')->default(false);
            $table->string('wht_label')->default('WHT (5%)');
            $table->decimal('wht_rate', 5, 2)->default(5.00);

            // Notes & content
            $table->text('completed_notes')->nullable();
            $table->text('proposed_notes')->nullable();
            $table->boolean('has_proposed')->default(false);

            // Payment details
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
