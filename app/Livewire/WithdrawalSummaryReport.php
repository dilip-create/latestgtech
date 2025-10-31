<?php
namespace App\Livewire;
use Livewire\Component;

use Livewire\WithPagination;
use App\Models\WithdrawTransaction;
use App\Exports\WithdrawalReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class WithdrawalSummaryReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $statusFilter = 'all';
    public $search = '';
    public $startDate;
    public $endDate;
    public $totalAmount = 0;
    public $totalmdrfee = 0;
    public $totalNetAmount = 0;

    protected $queryString = ['statusFilter', 'search', 'startDate', 'endDate'];

    public function mount()
    {
        // 🗓️ Default start and end date = today
        $today = now()->format('Y-m-d');
        $this->startDate = $today;
        $this->endDate = $today;

        $this->calculateTotals();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['statusFilter', 'search', 'startDate', 'endDate'])) {
            $this->resetPage();
            $this->calculateTotals();
        }
    }

    public function exportExcel()
    {
        return Excel::download(
            new WithdrawalReportExport(
                $this->statusFilter,
                $this->startDate,
                $this->endDate,
                $this->search
            ),
            'withdrawal-summary-report.xlsx'
        );
    }

    public function calculateTotals()
    {
        $query = WithdrawTransaction::query();

        // Role-based filter
        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        // Status
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        } else {
            $query->where('status', 'success'); // Default totals for success
        }

        // Date range (always applied)
        $query->whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59',
        ]);

        // Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('merchant_code', 'like', "%{$this->search}%")
                    ->orWhere('reference_id', 'like', "%{$this->search}%")
                    ->orWhere('systemgenerated_TransId', 'like', "%{$this->search}%")
                    ->orWhere('customer_name', 'like', "%{$this->search}%");
            });
        }

        $this->totalAmount = $query->sum('total');
        $this->totalmdrfee = $query->sum('mdr_fee_amount');
        $this->totalNetAmount = $query->sum('net_amount');
    }

    public function getTransactions()
    {
        $query = WithdrawTransaction::query();

        // Role-based filter
        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Date range
        $query->whereBetween('created_at', [
            $this->startDate . ' 00:00:00',
            $this->endDate . ' 23:59:59',
        ]);

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('merchant_code', 'like', "%{$this->search}%")
                    ->orWhere('reference_id', 'like', "%{$this->search}%")
                    ->orWhere('systemgenerated_TransId', 'like', "%{$this->search}%")
                    ->orWhere('customer_name', 'like', "%{$this->search}%");
            });
        }

        return $query->orderByDesc('id')->paginate(10);
    }

    public function render()
    {
        $title = __('messages.Withdrawal Summary Report');

        // Always return a collection for the view
        $transactions = $this->getTransactions();

        return view('livewire.withdrawal-summary-report', [
            'transactionlist' => $transactions,
        ])->title($title);
    }
    
}
