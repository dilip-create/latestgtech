<?php
namespace App\Livewire\Fc;
use Livewire\Component;
use App\Models\Qrgenerater;

class QrcodeList extends Component
{
    public $record;
    public function mount()
    {
        $this->record = Qrgenerater::orderBy('id', 'desc')->get();
        // dd($this->record);
    }

    public function render()
    {
        $title =   __('messages.Summary Report');
        return view('livewire.fc.qrcode-list')->title($title);
    }
}
