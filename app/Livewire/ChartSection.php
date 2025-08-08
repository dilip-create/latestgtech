<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\DepositTransaction;
use Carbon\Carbon;
use Session;

class ChartSection extends Component
{
     public $chartData = [];
    public $days = 7;

    public function mount()
    {
        $this->loadChartData($this->days);
    }

    public function loadChartData($days)
    {
        $this->days = $days;

        $query = DepositTransaction::query()
            ->where('payment_status', 'success')
            ->whereDate('created_at', '>=', now()->subDays($days));

        $auth = Session::get('auth');

        if ($auth->role_name === 'Merchant') {
            $query->where('merchant_id', $auth->merchant_id);
        } elseif ($auth->role_name === 'Agent') {
            $query->where('agent_id', $auth->agent_id);
        }

        $grouped = $query->get()->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('d-m-y');
        });

        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('d-m-y');
            $amount = isset($grouped[$date]) ? $grouped[$date]->sum('amount') : 0;

            $data[] = ['label' => $date, 'y' => (float) $amount];
        }

        $this->chartData = $data;
    }
    
    public function render()
    {
        return view('livewire.chart-section');
    }
}
