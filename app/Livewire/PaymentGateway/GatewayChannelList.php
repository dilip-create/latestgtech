<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use App\Models\GatewayChannel;
use Livewire\WithDispatchesEvents;
use Livewire\WithPagination;

class GatewayChannelList extends Component
{
    public function render()
    {
        return view('livewire.payment-gateway.gateway-channel-list');
    }
}
