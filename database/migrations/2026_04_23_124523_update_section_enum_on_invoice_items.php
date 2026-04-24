<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE invoice_items MODIFY COLUMN section ENUM('completed','proposed','subscription') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE invoice_items MODIFY COLUMN section ENUM('completed','proposed') NOT NULL");
    }
};
