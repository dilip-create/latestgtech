<table>
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
    @php $index = 0; @endphp
    @foreach($transactionlist as $row)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
            <td>{{ $row->systemgenerated_TransId }}</td>
            <td>{{ $row->merchant_code }}</td>
            <td>{{ $row->reference_id }}</td>
            <td>{{ $row->customer_name }}</td>
            <td>{{ $row->amount }}</td>
            <td>{{ $row->mdr_fee_amount }}</td>
            <td>{{ $row->net_amount }}</td>
            <td>{{ $row->Currency }}</td>
            <td>{{ ucfirst($row->payment_status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
