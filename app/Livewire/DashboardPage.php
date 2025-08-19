<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\DepositTransaction;
use App\Models\WithdrawTransaction;
use App\Models\Agent;
use App\Models\Merchant;
use Carbon\Carbon;
use Session;

class DashboardPage extends Component
{
    public $totalDepositCount, $total_transactions_amount_today, $total_payout_count, $total_transactions_amount_month, $totalDepositSum, $total_payout, $totalFee;
    public $total_agent, $total_merchant, $total_deposit_amount, $total_transactions_count;
    public $merchantData, $agentData;
    public function mount()
    {
        if(Session::get('auth')->role_name == 'Merchant'){
            
            $this->totalDepositCount = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->count('amount');
            $this->total_transactions_amount_today = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->whereDate('created_at', today())
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_payout_count = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->count('total');
            $this->total_transactions_amount_month = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->whereMonth('created_at', now()->month)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->totalDepositSum = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_payout = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->sum('total');
            ///////////////////////////////////////////
            $totalDepositFee = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('payment_status', 'success')
                                ->sum('mdr_fee_amount');
            $totalPayoutFee = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)
                                ->where('status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalFee=$totalDepositFee+$totalPayoutFee;

            $this->merchantData=Merchant::where('id', Session::get('auth')->merchant_id)->first();
            if (empty($this->merchantData)) {
                return 'Invalid Merchants!';
            }
            $this->agentData=Agent::where('id', $this->merchantData->agent_id)->first();
        
        }elseif(Session::get('auth')->role_name == 'Agent'){

            $this->totalDepositCount = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->count('amount');
            $this->total_transactions_amount_today = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->whereDate('created_at', today())
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_payout_count = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->count('total');
            $this->total_transactions_amount_month = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->whereMonth('created_at', now()->month)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->totalDepositSum = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_payout = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->sum('total');
            ///////////////////////////////////////////
            $totalDepositFee = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('payment_status', 'success')
                                ->sum('mdr_fee_amount');
            $totalPayoutFee = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)
                                ->where('status', 'success')
                                ->sum('mdr_fee_amount');
            $this->totalFee=$totalDepositFee+$totalPayoutFee;
            $this->agentData=Agent::where('id', Session::get('auth')->agent_id)->first();
            
        }else{
            $this->totalDepositCount = DepositTransaction::where('payment_status', 'success')
                                ->count('amount');
            $this->total_transactions_amount_today = DepositTransaction::whereDate('created_at', today())
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_payout_count = WithdrawTransaction::where('status', 'success')
                                ->count('total');
            $this->total_transactions_amount_month = DepositTransaction::whereMonth('created_at', now()->month)
                                ->where('payment_status', 'success')
                                ->sum('amount');
            $this->total_agent = Agent::count();
            $this->total_merchant =  Merchant::count();
            $this->total_deposit_amount = DepositTransaction::where('payment_status',  'success')->sum('amount');
            
            // $this->total_transactions_count = DepositTransaction::count();
        }
        // dd($this->merchantData);
        // dd($this->merchantData);
    }

    public function render()
    {
        $title =   __('messages.Dashboard');
        return view('livewire.dashboard-page')->title($title);
    }
}
