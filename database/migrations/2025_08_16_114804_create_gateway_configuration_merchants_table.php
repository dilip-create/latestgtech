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
        Schema::create('gateway_configuration_merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gateway_account_id')->constrained('gateway_accounts');
            $table->foreignId('merchant_id')->constrained('merchants');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_configuration_merchants');
    }
};
