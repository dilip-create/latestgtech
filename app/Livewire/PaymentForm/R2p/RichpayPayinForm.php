<?php
namespace App\Livewire\PaymentForm\R2p;
use Livewire\Component;

class RichpayPayinForm extends Component
{
    public function render()
    {
        $title =   __('Payment - Deposit Form');
        return view('livewire.payment-form.r2p.richpay-payin-form')->layout('components.layouts.master')->title($title);
    }
}
