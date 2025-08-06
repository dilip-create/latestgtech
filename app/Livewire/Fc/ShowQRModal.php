<?php
namespace App\Livewire\Fc;
use Livewire\Component;
use App\Models\Qrgenerater;

class ShowQRModal extends Component
{
    public $showModal = false;
    public $record;

    #[\Livewire\Attributes\On('openmodal')]
    public function loadData($id)
    {
        dd($id);
        $this->record = Qrgenerater::find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }


    public function render()
    {
        return view('livewire.fc.show-q-r-modal');
    }
}
