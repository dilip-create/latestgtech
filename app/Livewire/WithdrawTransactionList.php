<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\WithdrawTransaction;
use Session;

class WithdrawTransactionList extends Component
{

    public $transactionlist, $totalAmount, $totalmdrfee, $totalNetAmount;
    public function mount()
    {
        if(Session::get('auth')->role_name == 'Merchant'){
            $this->transactionlist = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)->select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'total', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'status', 'callback_url', 'customer_bank_name', 'bank_code', 'customer_account_number', 'created_at')->get();
            $this->totalAmount = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->sum('total');
            $this->totalmdrfee = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->sum('net_amount');
            
        
        }elseif(Session::get('auth')->role_name == 'Agent'){
            $this->transactionlist = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)->select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'total', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'status', 'callback_url', 'customer_bank_name', 'bank_code', 'customer_account_number', 'created_at')->get();
            $this->totalAmount = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->sum('total');
            $this->totalmdrfee = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->sum('net_amount');
        }else{
            $this->transactionlist = WithdrawTransaction::select('merchant_code', 'reference_id', 'systemgenerated_TransId', 'total', 'net_amount', 'mdr_fee_amount', 'customer_name', 'Currency', 'status', 'callback_url', 'customer_bank_name', 'bank_code', 'customer_account_number', 'created_at')->get();
            $this->totalAmount = WithdrawTransaction::where('status', 'success')
                                ->sum('total');
            $this->totalmdrfee = WithdrawTransaction::where('status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalNetAmount = WithdrawTransaction::where('status', 'success')
                                ->sum('net_amount');
        }
        // dd($this->transactionlist);
    }

    public function render()
    {
        return view('livewire.withdraw-transaction-list');
    }
}
