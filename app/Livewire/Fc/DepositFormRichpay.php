<?php
namespace App\Livewire\Fc;
use Livewire\Component;

class DepositFormRichpay extends Component
{
    public $amount, $invoice_number, $customer_name;
    public function mount($amount, $invoice_number, $customer_name)
    {
         // dd($this->record->qr_img_url);
        $this->amount = base64_decode($amount);
        $this->invoice_number = base64_decode($invoice_number);
        $this->customer_name = base64_decode($customer_name);
       
    }

    public function render()
    {
         $title =   __('PAYMENT GATEWAY - QR');
        return view('livewire.fc.deposit-form-richpay')->layout('components.layouts.master')->title($title);
    }
}
