<?php
namespace App\Livewire\Fc;
use Livewire\Component;
use App\Models\Qrgenerater;

class ShowQR extends Component
{
    public $record;
    public function mount($recordID)
    {
        $this->record = Qrgenerater::where('id', base64_decode($recordID))->first();
        // dd($this->record->qr_img_url);
    }
    public function render()
    {
        $title =   __('PAYMENT GATEWAY - QR');
        return view('livewire.fc.show-q-r')->layout('components.layouts.master')->title($title);
    }
}
