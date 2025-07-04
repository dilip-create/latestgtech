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
        Schema::create('withdraw_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_TransId')->nullable();     // main transactionID
            $table->string('systemgenerated_TransId')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('gateway_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->longText('callback_url')->nullable();
            $table->string('Currency')->nullable();
            $table->string('total')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('mdr_fee_amount')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->string('merchant_code')->nullable();
            $table->integer('agent_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('payment_method')->nullable();
            $table->longText('message')->nullable();
            $table->longText('api_response')->nullable();
            $table->string('customer_bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('customer_account_number')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_transactions');
    }
};
