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
    use WithPagination;

    // Use Bootstrap pagination markup (optional)
    protected $paginationTheme = 'bootstrap';

    // Table controls
    public string $search = '';
    public int $perPage = 10;

    // Modal state
    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?int $editChannelId = null;

    // Form state
    public array $gateways = [];
    public array $channels = [];
    public $selectedGateway = '';
    public $selectedChannel = '';
    public array $parameters = [['parameter_name' => '', 'parameter_value' => '']];
     
    // ---------- Lifecycle ----------
    public function mount(): void
    {
        $this->gateways = GatewayAccount::where('status', 1)->orderBy('id', 'desc')->get()->toArray();
       
    }

    // ---------- Reactive hooks ----------
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedGateway(): void
    {
        $this->channels = GatewayChannel::where('gateway_account_id', $this->selectedGateway)
            ->where('status', 1)
            ->orderBy('channel_name')
            ->get()
            ->toArray();

        // reset channel when gateway changes
        $this->selectedChannel = '';
    }

    // ---------- Table data ----------
    public function getData()
    {
        $query = GatewayChannel::query()
            ->with(['gatewayAccount', 'parameters'])
            ->where('status', 1);

        if (trim($this->search) !== '') {
            $s = "%{$this->search}%";
            $query->where(function ($q) use ($s) {
                $q->where('channel_name', 'like', $s)
                  ->orWhereHas('gatewayAccount', fn($g) => $g->where('gateway_name', 'like', $s))
                  ->orWhereHas('parameters', function ($p) use ($s) {
                      $p->where('parameter_name', 'like', $s)
                        ->orWhere('parameter_value', 'like', $s);
                  });
            });
        }

        return $query->orderBy('id', 'desc')->paginate($this->perPage);
    }

    // ---------- Modal helpers ----------
    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }



    public function edit(int $channelId): void
    {
        $this->resetForm();

        $channel = GatewayChannel::with('parameters')->findOrFail($channelId);

        $this->isEditMode     = true;
        $this->editChannelId  = $channel->id;
        $this->selectedGateway = $channel->gateway_account_id;

        // populate channel dropdown for the selected gateway
        $this->channels = GatewayChannel::where('gateway_account_id', $this->selectedGateway)
            ->where('status', 1)
            ->orderBy('channel_name')
            ->get()
            ->toArray();

        $this->selectedChannel = $channel->id;

        // load existing parameters
        foreach($channel->parameters as $index => $row){
            
            $dd [] = 'parameter_name_'.$row->parameter_name;
            // $dd [] = 'parameter_value_'.$index;
        }
        //  dd($dd);
        $this->parameters = $channel->parameters->map(fn($p) => [
            'name'  => $p->parameter_name,
            'value' => $p->parameter_value,
        ])->values()->toArray();
            
        if (empty($this->parameters)) {
            $this->parameters = [['parameter_name' => '', 'parameter_value' => '']];
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->isEditMode       = false;
        $this->editChannelId    = null;
        $this->selectedGateway  = '';
        $this->selectedChannel  = '';
        $this->channels         = [];
        $this->parameters       = [['parameter_name' => '', 'parameter_value' => '']];
    }




    // ---------- Dynamic rows ----------
    public function addParameterRow(): void
    {
        $this->parameters[] = ['parameter_name' => '', 'parameter_value' => ''];
    }

    public function removeParameterRow(int $index): void
    {
        unset($this->parameters[$index]);
        $this->parameters = array_values($this->parameters);
        if (empty($this->parameters)) {
            $this->parameters = [['parameter_name' => '', 'parameter_value' => '']];
        }
    }

    // ---------- Save ----------
    public function save()
    {
        $this->validate([
            'selectedGateway' => 'required|exists:gateway_accounts,id',
            'selectedChannel' => 'required|exists:gateway_channels,id',
            // 'parameters.*.name'  => 'required|string|max:255',
            // 'parameters.*.value' => 'required|string|max:255',
        ]);

        // keep only filled rows
        $rows = collect($this->parameters)
            ->map(fn($r) => ['name' => trim($r['name'] ?? ''), 'value' => trim($r['value'] ?? '')])
            ->filter(fn($r) => $r['name'] !== '' && $r['value'] !== '')
            ->values();
        // dd($rows);
        // upsert each (unique by channel_id + parameter_name)
        foreach ($rows as $row) {
            GatewayChannelParameter::updateOrCreate(
                [
                    'channel_id'     => $this->selectedChannel,
                    'parameter_name' => $row['name'],
                ],
                [
                    'parameter_value' => $row['value'],
                ],
            );
        }

        // (optional) delete params removed in form
        $keepNames = $rows->pluck('name')->all();
        GatewayChannelParameter::where('channel_id', $this->selectedChannel)
            ->whereNotIn('parameter_name', $keepNames)
            ->delete();

        $msg = $this->isEditMode
            ? __('messages.Parameter updated successfully!')
            : __('messages.Parameter added successfully!');

        // toast + cleanup
        $this->dispatch('toast', message: $msg, notify: 'success');
        $this->closeModal();

        // refresh table
        $this->resetPage();
    }

    // ---------- Render ----------
    public function render()
    {
        
        return view('livewire.payment-gateway.channel-parameter', [
            'records' => $this->getData(),
        ]);
    }
    // public function render()
    // {
    //     return view('livewire.payment-gateway.channel-parameter');
    // }
}
