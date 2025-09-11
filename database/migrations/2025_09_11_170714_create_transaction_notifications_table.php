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
        Schema::create('transaction_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('notifiable_type')->nullable();  
            $table->string('agent_id')->nullable();  
            $table->string('merchant_id')->nullable();  
            $table->boolean('readby_agent')->default(false);
            $table->boolean('readby_merchant')->default(false);
            $table->boolean('readby_admin')->default(false);
            $table->longText('data')->nullable();  
            $table->string('msg')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_notifications');
    }
};
