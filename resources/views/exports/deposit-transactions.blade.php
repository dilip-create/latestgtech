<table>
    <thead>
    <tr>
        <th>Order Id</th>
        <th>Created Time</th>
        <th>Transaction ID</th>
        <th>Merchant Code</th>
        <th>Reference ID</th>
        <th>Customer Name</th>
        <th>Amount</th>
        <th>MDR</th>
        <th>Net</th>
        <th>Currency</th>
        <th>Status</th>
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
