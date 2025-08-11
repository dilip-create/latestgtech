<?php
namespace App\Livewire\Layouts;
use Livewire\Component;
use Session;

class Header extends Component
{

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
