<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $guarded = ['id'];
    
    // public function gatewayConfigurations()
    // {
    //     return $this->hasMany(GatewayConfigurationMerchant::class, 'merchant_id');
    // }

    // public function gatewayConfigurations()
    // {
    //     return $this->hasMany(GatewayConfigurationMerchant::class);
    // }

}
