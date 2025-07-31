<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaction Information as follows</title>
    <style>
        body {
            background: #64b0f2;
        }

        .h1-class-success {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        .h1-class-Processing {
            color: rgb(0, 140, 255);
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .h1-class-fail {
            color: red;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .p-class {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }

        .success {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .Processing {
            color: rgb(0, 140, 255);
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }

        .fail {
            color: red;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }

        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }

        .btn_custom {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @if ($data['payment_status'] == 'success' || $data['payment_status'] == 'Success' || $data['payment_status'] == 'SUCCESS')
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <h1 class="p-class h1-class-Processing">THANK YOU FOR YOUR PAYMENT!</h1><br/>
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="success">✓</i>
                </div>
                <h1 class="h1-class-success">Status : Success</h1>
                <div style="text-align: left; padding: 10px 0;">
                    <p class="p-class">Currency : {{$data['Currency'] ?? ''}}</p>
                    <p class="p-class">Amount : {{$data['amount'] ?? ''}}</p>
                    <p class="p-class">Type : Deposit</p>
                    <p class="p-class">ReferenceId : {{$data['referenceId'] ?? ''}}</p>
                    <p class="p-class">Customer name : {{$data['customer_name'] ?? ''}}</p>
                    <p class="p-class">TransactionId : {{$data['transaction_id'] ?? ''}}</p>
                    <p class="p-class">Datetime : {{$data['created_at'] ?? ''}}</p>
                </div>
            </div>
        </div>
    @elseif ($data['payment_status'] == 'pending' || $data['payment_status'] == 'Pending' || $data['payment_status'] == 'PENDING')
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <h1 class="p-class h1-class-Processing">THANK YOU FOR YOUR PAYMENT!</h1><br/>
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="fail">!</i>
                </div>
                <h1 class="h1-class-fail">Status : Pending</h1>
                <div style="text-align: left; padding: 10px 0;">
                    <p class="p-class">Currency : {{$data['Currency'] ?? ''}}</p>
                    <p class="p-class">Amount : {{$data['amount'] ?? ''}}</p>
                    <p class="p-class">Type : Deposit</p>
                    <p class="p-class">ReferenceId : {{$data['referenceId'] ?? ''}}</p>
                    <p class="p-class">Customer name : {{$data['customer_name'] ?? ''}}</p>
                    <p class="p-class">TransactionId : {{$data['transaction_id'] ?? ''}}</p>
                    <p class="p-class">Datetime : {{$data['created_at'] ?? ''}}</p>
                </div>
            </div>
        </div>
    @elseif ($data['payment_status'] == 'processing' || $data['payment_status'] == 'Processing' || $data['payment_status'] == 'PROCESSING')
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <h1 class="p-class h1-class-Processing">THANK YOU FOR YOUR PAYMENT!</h1><br/>
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="Processing">!</i>
                </div>
                <h1 class="h1-class-Processing">Status : Processing...</h1>
                <div style="text-align: left; padding: 10px 0;">
                    <p class="p-class">Currency : {{$data['Currency'] ?? ''}}</p>
                    <p class="p-class">Amount : {{$data['amount'] ?? ''}}</p>
                    <p class="p-class">Type : Deposit</p>
                    <p class="p-class">ReferenceId : {{$data['referenceId'] ?? ''}}</p>
                    <p class="p-class">Customer name : {{$data['customer_name'] ?? ''}}</p>
                    <p class="p-class">TransactionId : {{$data['transaction_id'] ?? ''}}</p>
                    <p class="p-class">Datetime : {{$data['created_at'] ?? ''}}</p>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <h1 class="p-class h1-class-Processing">THANK YOU FOR YOUR PAYMENT!</h1><br/>
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="fail">!</i>
                </div>
                <h1 class="h1-class-fail">Status : Fail</h1>
                <div style="text-align: left; padding: 10px 0;">
                    <p class="p-class">Currency : {{$data['Currency'] ?? ''}}</p>
                    <p class="p-class">Amount : {{$data['amount'] ?? ''}}</p>
                    <p class="p-class">Type : Deposit</p>
                    <p class="p-class">ReferenceId : {{$data['referenceId'] ?? ''}}</p>
                    <p class="p-class">Customer name : {{$data['customer_name'] ?? ''}}</p>
                    <p class="p-class">TransactionId : {{$data['transaction_id'] ?? ''}}</p>
                    <p class="p-class">Datetime : {{$data['created_at'] ?? ''}}</p>
                </div>
            </div>
        </div>
    @endif
</body>

</html>
