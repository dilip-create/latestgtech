<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use App\Models\GatewayChannel;
use App\Models\GatewayChannelParameter;
use Livewire\WithDispatchesEvents;
use Livewire\WithPagination;

class ChannelParameter extends Component
{
    public function render()
    {
        return view('livewire.payment-gateway.channel-parameter');
    }
}
