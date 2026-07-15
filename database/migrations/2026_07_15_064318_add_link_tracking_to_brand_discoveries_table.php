<?php
// database/migrations/xxxx_xx_xx_add_link_tracking_to_brand_discoveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->string('token', 64)->nullable()->unique()->after('client_token');
            $table->timestamp('opened_at')->nullable()->after('token');
            $table->timestamp('submitted_at')->nullable()->after('opened_at');
        });

        // Required-at-submission fields need to be nullable at the DB level
        // so we can create a "shell" record before the client fills anything in.
        // Raw SQL used here to avoid a doctrine/dbal dependency for column modification.
        DB::statement('ALTER TABLE brand_discoveries MODIFY name VARCHAR(255) NULL');
        DB::statement('ALTER TABLE brand_discoveries MODIFY brand_name VARCHAR(255) NULL');
        DB::statement('ALTER TABLE brand_discoveries MODIFY email VARCHAR(255) NULL');

        // Widen status from enum to a plain string so the pipeline can grow
        // without another schema-altering migration later.
        DB::statement("ALTER TABLE brand_discoveries MODIFY status VARCHAR(20) NOT NULL DEFAULT 'submitted'");

        // Backfill: every existing row was submitted directly (no link flow),
        // so treat their created_at as the submission time.
        DB::table('brand_discoveries')->whereNull('submitted_at')->update([
            'submitted_at' => DB::raw('created_at'),
        ]);
        DB::table('brand_discoveries')->where('status', 'new')->update(['status' => 'submitted']);
    }

    public function down(): void
    {
        Schema::table('brand_discoveries', function (Blueprint $table) {
            $table->dropColumn(['token', 'opened_at', 'submitted_at']);
        });

        DB::statement("ALTER TABLE brand_discoveries MODIFY status ENUM('new','reviewed','archived') NOT NULL DEFAULT 'new'");
        DB::table('brand_discoveries')->where('status', 'submitted')->update(['status' => 'new']);

        DB::statement('ALTER TABLE brand_discoveries MODIFY name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE brand_discoveries MODIFY brand_name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE brand_discoveries MODIFY email VARCHAR(255) NOT NULL');
    }
};
