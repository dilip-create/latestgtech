<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\DepositTransaction;
use Session;

class DashboardPage extends Component
{
    public function render()
    {
        $title =   __('messages.Dashboard');
        return view('livewire.dashboard-page')->title($title);
    }
}
