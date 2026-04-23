<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * due_date stores free-text values like "Upon Receipt", "Net 30", or an
     * actual date string.  It must be a varchar, not a DATE column.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('due_date', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revert carefully — existing free-text values will be lost
            $table->date('due_date')->nullable()->change();
        });
    }
};
