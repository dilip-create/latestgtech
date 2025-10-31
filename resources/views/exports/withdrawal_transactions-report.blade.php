<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.Withdrawal Report') }}</title>
</head>
<body>
    <h3>{{ __('messages.Withdrawal Report') }}</h3>
    <p>
        <strong>{{ __('messages.Status') }}:</strong> {{ ucfirst($statusFilter) }}<br>
        <strong>{{ __('messages.Date Range') }}:</strong> {{ $startDate }} {{ __('messages.to') }} {{ $endDate }}
    </p>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>{{ __('messages.Order Id') }}</th>
                <th>{{ __('messages.Created Time') }}</th>
                <th>{{ __('messages.Transaction ID') }}</th>
                @if (Session::get('auth')->role_name != 'Merchant') 
                    <th>{{ __('messages.Merchant Code') }}</th>
                @endif
                @if(Session::get('auth')->merchant_id  == '1')       
                    <th>{{ __('messages.Invoice Number') }}</th>     {{-- For FC Department --}}
                @else
                    <th>{{ __('messages.Reference ID') }}</th>
                @endif
                <th>{{ __('messages.Customer Name') }} </th>
                <th>{{ __('messages.Amount') }} </th>
                <th>{{ __('messages.MDR') }} </th>
                <th>{{ __('messages.Net') }} </th>
                <th>{{ __('messages.Currency') }}</th>
                <th>{{ __('messages.Status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
                    <td>{{ $row->systemgenerated_TransId }}</td>
                    @if (Session::get('auth')->role_name != 'Merchant') 
                        <td>{{ $row->merchant_code }}</td>
                    @endif
                    <td>{{ $row->reference_id }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ number_format($row->total, 2) }}</td>
                    <td>{{ number_format($row->mdr_fee_amount, 2) }}</td>
                    <td>{{ number_format($row->net_amount, 2) }}</td>
                    <td>{{ $row->Currency }}</td>
                    <td>{{ ucfirst($row->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" align="center">{{ __('messages.Record not found') }}!</td>
                </tr>
            @endforelse

            @if($transactions->count() > 0)
                <tr>
                    @if (Session::get('auth')->role_name != 'Merchant') 
                        <td colspan="6" align="right"><strong>{{ __('messages.Totals') }}!:</strong></td>
                    @else
                        <td colspan="5" align="right"><strong>{{ __('messages.Totals') }}!:</strong></td>
                    @endif
                    
                    <td><strong>{{ number_format($totalAmount, 2) }}</strong></td>
                    <td><strong>{{ number_format($totalmdrfee, 2) }}</strong></td>
                    <td><strong>{{ number_format($totalNetAmount, 2) }}</strong></td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
