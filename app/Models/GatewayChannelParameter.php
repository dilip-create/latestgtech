<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayChannelParameter extends Model
{
    protected $guarded = ['id'];

    public function channel()
    {
        return $this->belongsTo(GatewayChannel::class, 'channel_id');
    }
}
