<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('has_subscription')->default(false)->after('has_proposed');
            $table->decimal('subscription_discount', 12, 2)->default(0)->after('has_subscription');
            $table->string('subscription_discount_label')->nullable()->after('subscription_discount');
            $table->string('subscription_notes', 1000)->nullable()->after('subscription_discount_label');
            // Tax applies_to: extend to include 'subscription' and 'all'
            // The existing tax_applies_to column already accepts free strings via varchar,
            // so we just need to allow the new values — no schema change needed there.
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'has_subscription',
                'subscription_discount',
                'subscription_discount_label',
                'subscription_notes',
            ]);
        });
    }
};
