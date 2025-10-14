<?php

namespace App\Exports;

use App\Models\DepositTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Session;

class DepositReportExport implements FromView
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
        $query = DepositTransaction::query();

        // Role filter
        if (Session::get('auth')->role_name === 'Merchant') {
            $query->where('merchant_id', Session::get('auth')->merchant_id);
        } elseif (Session::get('auth')->role_name === 'Agent') {
            $query->where('agent_id', Session::get('auth')->agent_id);
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('payment_status', $this->statusFilter);
        }

        // Date range
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59',
            ]);
        }

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('merchant_code', 'like', "%{$this->search}%")
                    ->orWhere('reference_id', 'like', "%{$this->search}%")
                    ->orWhere('systemgenerated_TransId', 'like', "%{$this->search}%")
                    ->orWhere('customer_name', 'like', "%{$this->search}%");
            });
        }

        // Fetch all filtered transactions for table display
        $transactions = $query->orderByDesc('id')->get();

        // ✅ Compute totals only for successful transactions
        $successfulTransactions = (clone $query)->where('payment_status', 'success')->get();

        $totalAmount = $successfulTransactions->sum('amount');
        $totalmdrfee = $successfulTransactions->sum('mdr_fee_amount');
        $totalNetAmount = $successfulTransactions->sum('net_amount');

        return view('exports.deposit_transactions-report', [
            'transactions' => $transactions,
            'totalAmount' => $totalAmount,
            'totalmdrfee' => $totalmdrfee,
            'totalNetAmount' => $totalNetAmount,
            'statusFilter' => $this->statusFilter,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
