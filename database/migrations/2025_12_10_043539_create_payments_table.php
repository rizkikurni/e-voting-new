<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('subscription_plans')->cascadeOnDelete();

            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();

            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_gateway', 50)->default('midtrans');
            $table->json('payment_instruction')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('transaction_status', [
                'pending',
                'settlement',
                'capture',
                'deny',
                'cancel',
                'expire',
                'failure'
            ])->default('pending');

            $table->string('fraud_status')->nullable();
            $table->dateTime('transaction_time')->nullable();

            $table->json('payload_response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
