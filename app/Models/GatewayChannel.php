<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayChannel extends Model
{
    protected $guarded = ['id'];

    public function gatewayAccount()
    {
        return $this->belongsTo(GatewayAccount::class, 'gateway_account_id');
    }

    public function parameters()
    {
        return $this->hasMany(GatewayChannelParameter::class, 'channel_id');
    }

    public function gateway()
    {
        return $this->belongsTo(GatewayAccount::class, 'gateway_account_id');
    }


    

}
