<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_order');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps(); // Sudah mencakup `created_at` dan `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
