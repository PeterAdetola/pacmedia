<?php
// database/migrations/xxxx_xx_xx_add_expires_at_to_brand_discoveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};
