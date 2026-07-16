<?php
// database/migrations/xxxx_xx_xx_add_admin_adjustment_tracking_to_brand_discoveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->boolean('admin_adjusted')->default(false)->after('status');
            $table->timestamp('admin_adjusted_at')->nullable()->after('admin_adjusted');
            // Snapshot of exactly what the client submitted, taken the FIRST time
            // an admin edits — untouched afterward, no matter how many more edits follow.
            $table->json('original_submission')->nullable()->after('admin_adjusted_at');
        });
    }

    public function down(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->dropColumn(['admin_adjusted', 'admin_adjusted_at', 'original_submission']);
        });
    }
};
