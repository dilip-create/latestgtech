<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use App\Models\GatewayChannel;
use Livewire\WithDispatchesEvents;
use Livewire\WithPagination;

class GatewayChannelList extends Component
{
    use WithPagination;
    public $search = '';        // Searching
    public $perPage = 10;       // Records per page
    protected $paginationTheme = 'bootstrap';
    public $gatewayAccountdata;
    public function mount()
    {
        $this->gatewayAccountdata = GatewayAccount::where('status', '1')->get();
    }


    // FOR EDIT AND ADD RECORD FUNCTIONALITY CODE START
    public $channel_id, $channel_name, $channel_desc, $gateway_account_id;
    public $showModal = false; // To toggle the popup
    public $isEditMode = false; // To detect if editing or adding
    protected $rules = [
        'channel_name' => 'required|string|max:255',
        'channel_desc' => 'required',
        'gateway_account_id' => 'required',
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
        $paymentChannel = GatewayChannel::findOrFail($id);
        $this->channel_id = $paymentChannel->id;
        $this->channel_name = $paymentChannel->channel_name;
        $this->channel_desc = $paymentChannel->channel_desc;
        $this->gateway_account_id = $paymentChannel->gateway_account_id;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    /** Save or update record */
    public function saveGatewayAccount()
    {
        $this->validate();

        GatewayChannel::updateOrCreate(
            ['id' => $this->channel_id],
            [
                'channel_name' => $this->channel_name,
                'channel_desc' => $this->channel_desc,
                'gateway_account_id' => $this->gateway_account_id,
            ]
        );
        $this->getdata();
        $msg = $this->isEditMode  ? __('messages.Payment Channel updated successfully!') : __('messages.Payment Channel added successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        $this->closeModal();
    }

    /** Close modal */
    public function closeModal()
    {
        $this->resetInputFields();
        $this->showModal = false;
    }

    /** Reset input fields */
    private function resetInputFields()
    {
        $this->channel_id = null;
        $this->channel_name = '';
        $this->channel_desc = '';
        $this->gateway_account_id = '';
    }
    // FOR EDIT AND ADD RECORD FUNCTIONALITY CODE END


    public function getdata(){
        return GatewayChannel::query()
            ->where('gateway_account_id', 'like', "%{$this->search}%")
            ->orWhere('channel_name', 'like', "%{$this->search}%")
            ->orWhere('channel_desc', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
    }
    // FOR CHANGE STATUS CODE START
    public function toggleStatus($channelId)
    {
        $paymentChannel = GatewayChannel::find($channelId);
        if ($paymentChannel) {
            $paymentChannel->status = !$paymentChannel->status;
            $paymentChannel->save();
            // Emit an event to trigger SweetAlert in frontend
            $this->dispatch('status-changed');
        }
    }
    // FOR CHANGE STATUS CODE END
    // FOR DELETE RECORD CODE START
    protected $listeners = ['callDeleteListner' => 'delete'];
    public function deleteConfirmationFun($id){
      
        $this->channel_id = $id;
        $this->dispatch('show-delete-confirmation');
    }
    public function delete(){
      
         $data= GatewayChannel::find($this->channel_id);
         $data->delete();
         $this->getdata();
         $this->dispatch('recordDeleted');
    }
    // FOR DELETE RECORD CODE END


    

    public function render()
    {
        return view('livewire.payment-gateway.gateway-channel-list', [
            'channelrecords' => $this->getData(),
        ]);
    }

}
