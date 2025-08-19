<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;

class GatewayAccountList extends Component
{
    public $record;
    public function mount()
    {
        $this->record = GatewayAccount::orderBy('id', 'DESC')->get();
        // dd($this->gatewayData);
    }

    public function render()
    {
        return view('livewire.payment-gateway.gateway-account-list');
    }
}
