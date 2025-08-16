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
        Schema::create('gateway_channel_parameters', function (Blueprint $table) {
            $table->id();   
            $table->foreignId('channel_id')->constrained('gateway_channels');  
            $table->string('parameter_name')->nullable();  
            $table->string('parameter_value')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_channel_parameters');
    }
};
