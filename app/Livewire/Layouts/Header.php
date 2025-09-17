<?php
namespace App\Livewire\Layouts;
use Livewire\Component;
use App\Models\TransactionNotification;

use Session;

class Header extends Component
{

    public $NotificationCount = 0, $NotificationData;
    public function mount()
    {
        if(Session::get('auth')->role_name == 'Merchant'){
           
            $this->NotificationCount = TransactionNotification::where('merchant_id', Session::get('auth')->merchant_id)->where('readby_merchant', '0')->orderBy('created_at','DESC')->count();
            $this->NotificationData = TransactionNotification::where('merchant_id', Session::get('auth')->merchant_id)->where('readby_merchant', '0')->orderBy('created_at','DESC')->get();

        }elseif(Session::get('auth')->role_name == 'Agent'){

            $this->NotificationCount = TransactionNotification::where('agent_id', Session::get('auth')->agent_id)->where('readby_agent', '0')->orderBy('created_at','DESC')->count();
            $this->NotificationData = TransactionNotification::where('agent_id', Session::get('auth')->agent_id)->where('readby_agent', '0')->orderBy('created_at','DESC')->get();
            

        }else{
            $this->NotificationCount = TransactionNotification::where('readby_admin', '0')->orderBy('created_at','DESC')->count();
            $this->NotificationData = TransactionNotification::where('readby_admin', '0')->orderBy('created_at','DESC')->get();
        }
        // dd($this->transactionlist);


    }

    public function logout()
    {
        Session::flush();
        Session::forget('auth');
        $msg =  __('message.Logout Successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layouts.header');
    }
}
