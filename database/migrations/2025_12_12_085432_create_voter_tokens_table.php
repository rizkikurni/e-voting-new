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
        Schema::create('voter_tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            $table->string('token', 6)->unique(); // kode unik 6 digit
            $table->boolean('is_used')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voter_tokens');
    }
};
