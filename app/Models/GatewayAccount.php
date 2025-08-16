<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayAccount extends Model
{
    protected $guarded = ['id'];

    // public function channels()
    // {
    //     return $this->hasMany(GatewayChannel::class, 'gateway_account_id');
    // }

    public function channels()
    {
        return $this->hasMany(GatewayChannel::class);
    }

}
