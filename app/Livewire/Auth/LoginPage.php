<?php
namespace App\Livewire\Auth;
use Livewire\Component;
use Session;
use Livewire\Attributes\Rule;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class LoginPage extends Component
{
    #[Rule('required')]
    public $username, $password;
    public bool $showPassword = false;
    public function loginCheck()
    {
        $validated = $this->validate();
        $checkUser=User::where('user_name', $this->username)->first();

        if(!empty($checkUser)){
                // dd(base64_encode($checkUser->password));
                 if($checkUser->status == '0'){
                    $msg = 'Login Credentials Disabled!'; 
                    $this->dispatch('toast', message: $msg, notify:'error' ); 

                }elseif($checkUser->password == base64_encode($this->password)  ){
                    
                    unset($checkUser->password);
                    // dd($checkUser);
                    Session::put('auth', $checkUser);
                   
                    $msg = 'Login Successfully!';
                    $this->dispatch('toast', message: $msg, notify:'success' ); 
                    return $this->redirect('/dashboard', navigate: false);

                }else{
                    $msg = 'Invalid Username & Password!';
                    $this->dispatch('toast', message: $msg, notify:'error' ); 
                }
        }else{
            $msg = 'Invalid Username';
            $this->dispatch('toast', message: $msg, notify:'error' ); 
        } 
            $this->reset();

    }

    public function render()
    {
        $title =   __('PAYMENT GATEWAY - Login');
        return view('livewire.auth.login-page')->layout('components.layouts.master')->title($title);
    }


}
