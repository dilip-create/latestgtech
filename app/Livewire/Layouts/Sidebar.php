<?php
namespace App\Livewire\Layouts;
use Livewire\Component;
use App\Models\DepositTransaction;
use App\Models\WithdrawTransaction;
use Session;
use Carbon\Carbon;

class Sidebar extends Component
{
    public $todayDepositCount = 0, $todayWithdrawCount = 0;
    public function mount()
    {
        if(Session::get('auth')->role_name == 'Merchant' || Session::get('auth')->role_name == 'Agent'){
            $this->todayDepositCount = DepositTransaction::where('merchant_id', Session::get('auth')->merchant_id)->whereDate('created_at', Carbon::today())->count();
            $this->todayWithdrawCount = WithdrawTransaction::where('merchant_id', Session::get('auth')->merchant_id)->whereDate('created_at', Carbon::today())->count();


        }elseif(Session::get('auth')->role_name == 'Agent'){
            $this->todayDepositCount = DepositTransaction::where('agent_id', Session::get('auth')->agent_id)->whereDate('created_at', Carbon::today())->count();
            $this->todayWithdrawCount = WithdrawTransaction::where('agent_id', Session::get('auth')->agent_id)->whereDate('created_at', Carbon::today())->count();

        }else{
            $this->todayDepositCount = DepositTransaction::whereDate('created_at', Carbon::today())->count();
            $this->todayWithdrawCount = WithdrawTransaction::whereDate('created_at', Carbon::today())->count();
        }
        // dd($this->transactionlist);


    }

    public function logout()
    {
        // Session::flush();
        Session::forget('auth');
        $msg =  __('message.Logout Successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        // return redirect('/');
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
}
