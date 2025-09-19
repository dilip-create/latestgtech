<?php
namespace App\Livewire\Layouts;
use Livewire\Component;
use App\Models\TransactionNotification;

use Session;

class Header extends Component
{

    public $getNotification, $NotificationCount = 0, $NotificationData;
    public function mount()
    {
       $this->getNotification();
        // dd($this->transactionlist);
    }

    public function getNotification()
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
    }

    public function markReadTransaction()
    {

        if(Session::get('auth')->role_name == 'Merchant'){
            TransactionNotification::where('merchant_id', Session::get('auth')->merchant_id)->update(['readby_merchant' => '1']);

        }elseif(Session::get('auth')->role_name == 'Agent'){
            TransactionNotification::where('agent_id', Session::get('auth')->agent_id)->update(['readby_agent' => '1']);
            
        }else{
             TransactionNotification::select('*')->update(['readby_admin' => '1']);  
        }
        TransactionNotification::where([
            'readby_merchant' => '1',
            'readby_agent' => '1',
            'readby_admin' => '1'
        ])->delete();
        $this->getNotification();
        // return back();
        $msg =  __('messages.Done!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
    }

    public function logout()
    {
        Session::flush();
        Session::forget('auth');
        $msg =  __('messages.Logout Successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.layouts.header');
    }
}
