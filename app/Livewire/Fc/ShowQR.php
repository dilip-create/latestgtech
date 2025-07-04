<?php

namespace App\Livewire\Fc;

use Livewire\Component;

class ShowQR extends Component
{
    public function render()
    {
        $title =   __('PAYMENT GATEWAY - QR');
        return view('livewire.fc.show-q-r')->layout('components.layouts.master')->title($title);
    }
}
