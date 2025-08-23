<?php
namespace App\Livewire\PaymentGateway;
use Livewire\Component;
use App\Models\GatewayAccount;
use App\Models\GatewayChannel;
use App\Models\GatewayChannelParameter;
use Livewire\WithDispatchesEvents;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ChannelParameterDetails extends Component
{
    public $rows = [];

    public $channelId;

    public function mount($channelId = 1)
    {
        $this->channelId = $channelId;

        // Load existing parameters from DB
        $this->rows = DB::table('gateway_channel_parameters')
                        ->where('channel_id', $this->channelId)
                        ->get(['parameter_name', 'parameter_value'])
                        ->map(fn($item) => (array) $item)
                        ->toArray();

        // Ensure at least one row
        if (empty($this->rows)) {
            $this->rows[] = ['parameter_name' => '', 'parameter_value' => ''];
        }
    }

    public function addRow()
    {
        $this->rows[] = ['parameter_name' => '', 'parameter_value' => ''];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function save()
    {
        $this->validate([
            'rows.*.parameter_name' => 'required|string',
            'rows.*.parameter_value' => 'required|string',
        ]);

        // Remove old parameters for this channel
        DB::table('gateway_channel_parameters')
            ->where('channel_id', $this->channelId)
            ->delete();

        // Insert new parameters
        foreach ($this->rows as $row) {
            DB::table('gateway_channel_parameters')->insert([
                'channel_id' => $this->channelId,
                'parameter_name' => $row['parameter_name'],
                'parameter_value' => $row['parameter_value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->flash('message', 'Parameters saved successfully!');
    }

    public function render()
    {
        return view('livewire.payment-gateway.channel-parameter-details');
    }
}


