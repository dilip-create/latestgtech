<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\Agent;
use App\Models\Merchant;
use Session;
use Livewire\Attributes\Rule;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class ProfilePage extends Component
{
    public $merchantData, $agentData;
    #[Rule('required|min:8')]
    public $NewPassword, $confirmPassword, $oldPassword;
    public function mount()
    {
        $auth = Session::get('auth');

        if ($auth->role_name === 'Merchant') {
            $this->merchantData = Merchant::find($auth->merchant_id);

            if (!$this->merchantData) {
                abort(404, 'Invalid Merchant!');
            }

            $this->agentData = Agent::find($this->merchantData->agent_id);

        } elseif ($auth->role_name === 'Agent') {
            $this->agentData = Agent::find($auth->agent_id);
        }
    }

    public function changePass()
    {
        $validated = $this->validate();
        // dd(base64_encode($this->oldPassword));
        $checkUser=User::where('user_name', Session::get('auth')->user_name)->first();

        if(!empty($checkUser)){
                // dd(base64_encode($checkUser->password));
                 
                if($checkUser->password == base64_encode($this->oldPassword)  ){
                    
                        if($this->NewPassword == $this->confirmPassword){
                          
                            User::where('user_name', Session::get('auth')->user_name)
                                    ->update([
                                        'password' => base64_encode($this->NewPassword)
                                    ]);
                            $msg = 'Password updated Successfully!';
                            $this->dispatch('toast', message: $msg, notify:'success' ); 
                            Session::flush();
                            Session::forget('auth');
                            return $this->redirect('/', navigate: true);
                        }else{
                            $msg = 'New password not match with confirm password!';
                            $this->dispatch('toast', message: $msg, notify:'warning' ); 
                        }
            
                }else{
                    $msg = 'Incorrect old password!';
                    $this->dispatch('toast', message: $msg, notify:'error' ); 
                }
        }else{
            $msg = 'Invalid User!';
            $this->dispatch('toast', message: $msg, notify:'error' ); 
        } 
      

    }


    public function render()
    {
        $title =   __('messages.Profile');
        return view('livewire.profile-page')->title($title);
    }
}
