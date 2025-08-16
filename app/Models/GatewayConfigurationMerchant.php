<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayConfigurationMerchant extends Model
{
    protected $guarded = ['id'];

    // public function gatewayAccount()
    // {
    //     return $this->belongsTo(GatewayAccount::class, 'gateway_account_id');
    // }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function gatewayAccount()
    {
        return $this->belongsTo(GatewayAccount::class);
    }

}
