<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\DepositTransaction;
use Session;

class DepositTransactionList extends Component
{
    public $transactionlist, $totalAmount, $totalmdrfee, $totalNetAmount;
    public $statusFilter = 'all';
    public $dateFilter = 'today'; // default filter

    

    public function filterByDate($filter)
    {
        $this->dateFilter = $filter;
        $this->fetchTransactions();
    }

    public function updatedStatusFilter()
    {
        $this->fetchTransactions();
    }

    public function fetchTransactions()
    {
        $query = DepositTransaction::query();

        if (Session::get('auth')->role_name == 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name == 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('payment_status', $this->statusFilter);
        }

        // Apply date filter
        switch ($this->dateFilter) {
            case 'today':
                $query->whereDate('created_at', now());
                break;
            case 'yesterday':
                $query->whereDate('created_at', now()->subDay());
                break;
            case '7days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'this_week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year);
                break;
            case 'last_year':
                $query->whereYear('created_at', now()->subYear()->year);
                break;
        }

        $this->transactionlist = $query->orderBy('id', 'DESC')->get();

        // Recalculate totals for "success" only
        $successQuery = (clone $query)->where('payment_status', 'success');
        $this->totalAmount = $successQuery->sum('amount');
        $this->totalmdrfee = $successQuery->sum('mdr_fee_amount');
        $this->totalNetAmount = $successQuery->sum('net_amount');
    }

    public function mount()
    {
        $this->fetchTransactions();
    }



    public function render()
    {
        $title =   __('messages.Deposit Transactions');
        return view('livewire.deposit-transaction-list')->title($title);
    }
}
