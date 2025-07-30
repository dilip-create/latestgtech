<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\DepositTransaction;
use Session;

class DepositTransactionList extends Component
{
    public $transactionlist, $totalAmount, $totalmdrfee, $totalNetAmount;
    public function mount()
    {
        if(Session::get('auth')->role_name == 'Merchant'){
            $this->transactionlist = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)->select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'amount', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'payment_status', 'callback_url', 'bank_account_name', 'bank_code', 'bank_account_number', 'created_at')->orderBy('id', 'DESC')->get();
            $this->totalAmount = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->totalmdrfee = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->sum('net_amount');
            
        
        }elseif(Session::get('auth')->role_name == 'Agent'){
            $this->transactionlist = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)->select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'amount', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'payment_status', 'callback_url', 'bank_account_name', 'bank_code', 'bank_account_number', 'created_at')->orderBy('id', 'DESC')->get();
            $this->totalAmount = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->totalmdrfee = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->sum('net_amount');
        }else{
            $this->transactionlist = DepositTransaction::select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'amount', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'payment_status', 'callback_url', 'bank_account_name', 'bank_code', 'bank_account_number', 'created_at')->orderBy('id', 'DESC')->get();
            $this->totalAmount = DepositTransaction::where('payment_status', 'success')
                                ->sum('amount');
            $this->totalmdrfee = DepositTransaction::where('payment_status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = DepositTransaction::where('payment_status', 'success')
                                ->sum('net_amount');
        }
        // dd($this->transactionlist);
    }

    public function render()
    {
        return view('livewire.deposit-transaction-list');
    }
}
