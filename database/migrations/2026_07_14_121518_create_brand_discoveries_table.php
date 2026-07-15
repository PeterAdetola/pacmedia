<?php
// database/migrations/xxxx_xx_xx_create_brand_discoveries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_discoveries', function (Blueprint $table) {
            $table->id();

            // Links this submission back to a client if it was sent via /brand-discovery?client=slug
            $table->string('client_token')->nullable()->index();

            // 00 — About You
            $table->string('name');
            $table->string('brand_name');
            $table->string('email');
            $table->string('industry')->nullable();
            $table->string('brand_description')->nullable();
            $table->string('existing_brand')->nullable();

            // 01 — Audience Profile
            $table->text('persona')->nullable();
            $table->unsignedTinyInteger('age_min')->nullable();
            $table->unsignedTinyInteger('age_max')->nullable();
            $table->json('profile')->nullable(); // checkbox group

            // 02 — Tone & Brand Values (all 16 trait_* sliders, -3..3)
            $table->json('traits')->nullable();

            // 03 — Visual Direction
            $table->json('colour')->nullable();
            $table->json('typography')->nullable();
            $table->json('touchpoints')->nullable();

            // 04 — Competitive Context
            $table->text('competitors')->nullable();
            $table->text('differentiator')->nullable();
            $table->text('admired')->nullable();

            // 05 — Brand Ambition
            $table->text('five_year')->nullable();
            $table->string('urgency')->nullable();
            $table->text('anything_else')->nullable();

            // Admin workflow / housekeeping
            $table->enum('status', ['new', 'reviewed', 'archived'])->default('new');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_discoveries');
    }
};
