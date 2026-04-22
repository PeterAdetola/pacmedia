<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Billing cycle only relevant for subscription items; null for completed/proposed
            $table->string('billing_cycle')->nullable()->after('taxable'); // 'monthly' | 'annual'
            $table->date('renewal_date')->nullable()->after('billing_cycle');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn(['billing_cycle', 'renewal_date']);
        });
    }
};
