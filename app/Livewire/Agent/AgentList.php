<?php
namespace App\Livewire\Agent;
use Livewire\Component;
use App\Models\Agent;
use App\Models\User;
use Livewire\WithDispatchesEvents;
use Livewire\WithPagination;

class AgentList extends Component
{
    use WithPagination;
    public $search = '';        // Searching
    public $perPage = 10;       // Records per page
    protected $paginationTheme = 'bootstrap';


    // FOR EDIT AND ADD RECORD FUNCTIONALITY CODE START
    public $user_id, $agent_id, $name, $user_name, $email, $mobile_number, $password, $password_confirmation, $timezone='Asia/Bangkok';
    public $showModal = false; // To toggle the popup
    public $isEditMode = false; // To detect if editing or adding
    

    /** Open modal for adding new record */
    public function openAddModal()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    /** Open modal for editing */
    public function editConfirmationFun($id)
    {
        $userdata = User::findOrFail($id);
        $this->user_id = $userdata->id;
        $this->agent_id = $userdata->agent_id;
        $this->name = $userdata->name;
        $this->user_name = $userdata->user_name;
        $this->email = $userdata->email;
        $this->mobile_number = $userdata->mobile_number;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    /** Save or update record */
    public function saveGatewayAccount()
    {
        // no need to check unique at edit case code 
            $rules = [
                'name'          => 'required|string|max:255',
                'user_name'     => 'required|string|max:255|unique:users,user_name,' . $this->user_id,
                'email'         => 'required|email|max:255|unique:users,email,' . $this->user_id,
                'mobile_number' => 'required|numeric|digits_between:10,12',
            ];
        
        if ($this->isEditMode) {
            // Update case → only validate password if filled
            if (!empty($this->password) || !empty($this->password_confirmation)) {
                $rules['password'] = 'required|min:8|confirmed';
            }
        } else {
            // Create case → password is required
            $rules['password'] = 'required|min:8|confirmed';
        }
        $this->validate($rules);
        // dd(base64_encode($this->password));
         // Save or update Agent
        $agent = Agent::updateOrCreate(
            ['id' => $this->agent_id],
            [
                'agent_name' => $this->name,
                'agent_code' => $this->user_name,
            ]
        );

         $userData = [
            'name' => $this->name,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'role_id' => '3',  //for agent role
            'role_name' => 'Agent',
            'agent_id' => $agent->id,
        ];

        // Only update password if it's filled
        if (!empty($this->password)) {
            $userData['password'] = base64_encode($this->password);
        }
        
        User::updateOrCreate(
            ['id' => $this->user_id],
            $userData
        );


        $this->getdata();
        $msg = $this->isEditMode  ? __('messages.Agent updated successfully!') : __('messages.Agent added successfully!');
        $this->dispatch('toast', message: $msg, notify:'success' ); 
        $this->closeModal();
    }

    /** Close modal */
    public function closeModal()
    {
        $this->showModal = false;
    }

    /** Reset input fields */
    private function resetInputFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->user_name = '';
        $this->email = '';
        $this->mobile_number = '';
    }
    // FOR EDIT AND ADD RECORD FUNCTIONALITY CODE END


    public function getdata()
    {
        return User::query()
            ->where('role_name', 'Agent')
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('user_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('mobile_number', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
    }

    // FOR CHANGE STATUS CODE START
    public function toggleStatus($UserId)
    {
        $User = User::find($UserId);
        if ($User) {
            $User->status = !$User->status;
            $User->save();

            // For Agent Table
           $agent = Agent::find($User->agent_id);
            if ($agent) {
                $agent->status = $agent->status ? 0 : 1;
                $agent->save();
            }
        
            // Emit an event to trigger SweetAlert in frontend
            $this->dispatch('status-changed');
        }
    }
    // FOR CHANGE STATUS CODE END
    // FOR DELETE RECORD CODE START
    public $record_id;
    protected $listeners = ['callDeleteListner' => 'delete'];
    public function deleteConfirmationFun($id){
      
        $this->record_id = $id;
        $this->dispatch('show-delete-confirmation');
    }
    public function delete(){
      
         $data= User::find($this->record_id);
         $agentdata= Agent::find($data->agent_id);
         $agentdata->delete();
         $data->delete();
         $this->getdata();
         $this->dispatch('recordDeleted');
    }
    // FOR DELETE RECORD CODE END


    

    public function render()
    {
        return view('livewire.agent.agent-list', [
            'gateways' => $this->getData(),
        ]);
    }
}
