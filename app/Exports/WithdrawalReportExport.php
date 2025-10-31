<?php
namespace App\Exports;

use App\Models\WithdrawTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle; // ✅ add this
use Session;

class WithdrawalReportExport implements FromView, WithTitle // ✅ add WithTitle here
{
    protected $statusFilter;
    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($statusFilter, $startDate, $endDate, $search)
    {
        $this->statusFilter = $statusFilter;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->search = $search;
    }

    public function view(): View
    {
        $query = WithdrawTransaction::query();

        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59',
            ]);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('merchant_code', 'like', "%{$this->search}%")
                    ->orWhere('reference_id', 'like', "%{$this->search}%")
                    ->orWhere('systemgenerated_TransId', 'like', "%{$this->search}%")
                    ->orWhere('customer_name', 'like', "%{$this->search}%");
            });
        }

        $transactions = $query->orderByDesc('id')->get();

        $successfulTransactions = (clone $query)->where('status', 'success')->get();

        $totalAmount = $successfulTransactions->sum('total');
        $totalmdrfee = $successfulTransactions->sum('mdr_fee_amount');
        $totalNetAmount = $successfulTransactions->sum('net_amount');

        return view('exports.withdrawal_transactions-report', [
            'transactions' => $transactions,
            'totalAmount' => $totalAmount,
            'totalmdrfee' => $totalmdrfee,
            'totalNetAmount' => $totalNetAmount,
            'statusFilter' => $this->statusFilter,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }

    // ✅ This method forces a valid, short sheet title
    public function title(): string
    {
        return 'withdrawal-summary-report'; // must be < 31 characters
    }
}
