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
        Schema::create('deposit_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_code')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('systemgenerated_TransId')->nullable();
            $table->string('amount')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('mdr_fee_amount')->nullable();
            $table->string('gateway_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('Currency')->nullable();
            $table->string('gateway_TransId')->nullable();
            $table->string('payment_status')->nullable()->default('pending');
            $table->string('callback_url')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('product_id')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->longText('request_data')->nullable();
            $table->longText('payin_arr')->nullable();
            $table->longText('response_data')->nullable();
            $table->string('agent_id')->nullable();
            $table->string('merchant_id')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_transactions');
    }
};
