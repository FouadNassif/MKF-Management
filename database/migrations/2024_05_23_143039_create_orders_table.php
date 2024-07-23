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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('type');
            $table->foreignId('cashier_id')->nullable()->constrained("Users");
            $table->foreignId('driver_id')->nullable()->constrained("Users");
            $table->foreignId('waiter_id')->nullable()->constrained("Users");
            $table->foreignId('customer_id')->nullable()->constrained("Users");
            $table->integer("total")->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
