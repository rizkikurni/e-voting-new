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
         Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Standard, Premium
            $table->decimal('price', 12, 2)->default(0);

            // Features example: max_votes, max_candidates, watermark, etc
            $table->json('features')->nullable();
            $table->integer('max_event');
            $table->integer('max_candidates');
            $table->integer('max_voters');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
