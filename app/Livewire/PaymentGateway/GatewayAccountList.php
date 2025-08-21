<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use Livewire\WithDispatchesEvents;

class GatewayAccountList extends Component
{
    public $record;
    public function mount()
    {
        $this->getdata();
    }


    public $gateway_id, $gateway_name, $website_url, $payment_method;
    public $showModal = false; // To toggle the popup
    public $isEditMode = false; // To detect if editing or adding
    protected $rules = [
        'gateway_name' => 'required|string|max:255',
        'website_url' => 'required|url',
        'payment_method' => 'required|string|max:255',
    ];

    /** Open modal for adding new record */
    public function openAddModal()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    /** Open modal for editing */
    public function editConfirmationFun($id)
    {
        $gateway = GatewayAccount::findOrFail($id);

        $this->gateway_id = $gateway->id;
        $this->gateway_name = $gateway->gateway_name;
        $this->website_url = $gateway->website_url;
        $this->payment_method = $gateway->payment_method;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    /** Save or update record */
    public function saveGatewayAccount()
    {
        $this->validate();

        GatewayAccount::updateOrCreate(
            ['id' => $this->gateway_id],
            [
                'gateway_name' => $this->gateway_name,
                'website_url' => $this->website_url,
                'payment_method' => $this->payment_method,
            ]
        );
        $this->getdata();
        $msg =  $this->isEditMode ? 'Gateway updated successfully!' : 'Gateway added successfully!';
        // session()->flash('message', $this->isEditMode ? 'Gateway updated successfully!' : 'Gateway added successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        $this->closeModal();
        $this->dispatch('$refresh'); // Refresh data table
    }

    /** Close modal */
    public function closeModal()
    {
        $this->showModal = false;
    }

    /** Reset input fields */
    private function resetInputFields()
    {
        $this->gateway_id = null;
        $this->gateway_name = '';
        $this->website_url = '';
        $this->payment_method = '';
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
