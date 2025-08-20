<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use Livewire\WithDispatchesEvents;

class GatewayAccountList extends Component
{
    public $record;
    // public $gateway_id, $gateway_name, $website_url, $payment_method;
    public function mount()
    {
        $this->getdata();
    }

    public function getdata(){
        $this->record = GatewayAccount::orderBy('id', 'DESC')->get();
    }
    // FOR CHANGE STATUS CODE START
    public function toggleStatus($gatewayId)
    {
        $gateway = GatewayAccount::find($gatewayId);
        if ($gateway) {
            $gateway->status = !$gateway->status;
            $gateway->save();
            // Emit an event to trigger SweetAlert in frontend
            $this->dispatch('status-changed');
        }
    }
    // FOR CHANGE STATUS CODE END
    // FOR DELETE RECORD CODE START
    public $record_id;
    protected $listeners = ['callDeleteListner' => 'delete'];
    public function deleteConfirmationFun($id){
      
        $this->record_id = $id;
        $this->dispatch('show-delete-confirmation');
    }
    public function delete(){
      
         $data= GatewayAccount::find($this->record_id);
         $data->delete();
         $this->getdata();
         $this->dispatch('ticketCancelled');
    }
    // FOR DELETE RECORD CODE END


    // public function saveGatewayAccountData()
    // {
    //     dd($this);
    //     $this->validate();

    //     GatewayAccount::updateOrCreate(
    //         ['id' => $this->gateway_id],
    //         [
    //             'gateway_name' => $this->gateway_name,
    //             'website_url' => $this->website_url,
    //             'payment_method' => $this->payment_method,
    //         ]
    //     );

    //     // Close modal via JS after saving
    //     $this->dispatch('formSaved');
    // }
    

    public function render()
    {
        return view('livewire.payment-gateway.gateway-account-list');
    }
}
