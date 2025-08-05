<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\WithdrawTransaction;
use Session;

class WithdrawTransactionList extends Component
{

    public $transactionlist, $totalAmount, $totalmdrfee, $totalNetAmount;
    public $statusFilter = 'all';
    public $dateFilter = 'today';
    public $search = '';

    public function mount()
    {
        $this->calculateTotals(); // calculate once for $totalAmount, $totalmdrfee, $totalNetAmount;
        $this->getTransactions();
    }

    public function calculateTotals()
    {
        $query = WithdrawTransaction::query()
            ->where('status', 'success');

        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        $this->totalAmount = $query->sum('total');
        $this->totalmdrfee = $query->sum('mdr_fee_amount');
        $this->totalNetAmount = $query->sum('net_amount');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['statusFilter', 'dateFilter', 'search'])) {
            $this->getTransactions();
        }
    }

    public function getTransactions()
    {
        $query = WithdrawTransaction::query();

        // Role-based filtering
        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Date filter
        if ($this->dateFilter) {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->subDay());
                    break;
                case '7days':
                    $query->whereDate('created_at', '>=', now()->subDays(7));
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', now()->subYear()->year);
                    break;
            }
        }

        // Search filter
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('merchant_code', 'like', "%{$this->search}%")
                  ->orWhere('reference_id', 'like', "%{$this->search}%")
                  ->orWhere('systemgenerated_TransId', 'like', "%{$this->search}%")
                  ->orWhere('customer_name', 'like', "%{$this->search}%");
            });
        }

        $this->transactionlist = $query->orderByDesc('id')->get();

        // Totals
        // $successQuery = (clone $query)->where('status', 'success');
        // $this->totalAmount = $successQuery->sum('amount');
        // $this->totalmdrfee = $successQuery->sum('mdr_fee_amount');
        // $this->totalNetAmount = $successQuery->sum('net_amount');
    }


    public function render()
    {
        $title =   __('messages.Withdraw Transactions');
        return view('livewire.withdraw-transaction-list')->title($title);
    }
}
