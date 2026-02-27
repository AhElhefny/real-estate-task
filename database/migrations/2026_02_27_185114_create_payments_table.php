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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Multi-tenancy awareness
            $table->unsignedBigInteger('tenant_id')->index();

            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->cascadeOnDelete();

            $table->decimal('amount', 12, 2);

            // Use PHP 8.1 Backed Enum cast in the model
            $table->string('payment_method', 32);

            $table->string('reference_number')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
