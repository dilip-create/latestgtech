<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayChannel extends Model
{
    protected $guarded = ['id'];
    // public function parameters()
    // {
    //     return $this->hasMany(GatewayChannelParameter::class, 'channel_id');
    // }

    public function gatewayAccount()
    {
        return $this->belongsTo(GatewayAccount::class);
    }

    public function parameters()
    {
        return $this->hasMany(GatewayChannelParameter::class, 'channel_id');
    }

}
