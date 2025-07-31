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

        .h1-class-fail {
            color: red;
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
    @if ($postData['payment_status'] == 'success' || $postData['payment_status'] == 'Success' || $postData['payment_status'] == 'SUCCESS')
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="success">✓</i>
                </div>
                <h1 class="h1-class-success">Success</h1>
                <p class="p-class">We received your purchase request;<br /> we'll be in touch shortly!</p>
                <button class="btn_custom" onclick="goBack()">Go Back</button>
            </div>
        </div>
    @elseif ($postData['payment_status'] == 'pending' || $postData['payment_status'] == 'Pending' || $postData['payment_status'] == 'PENDING')
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="fail">!</i>
                </div>
                <h1 class="h1-class-fail">Pending</h1>
                <p class="p-class">Transaction has been sent to bank.<br />Pending From Bank!</p>
                <button class="btn_custom" onclick="goBack()">Go Back</button>
            </div>
        </div>
    @elseif ($postData['payment_status'] == 'processing' || $postData['payment_status'] == 'Processing' || $postData['payment_status'] == 'PROCESSING')
    <div style="text-align: center; padding: 40px 0;">
        <div class="card card-class">
            <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                <i class="Processing">!</i>
            </div>
            <h1 class="h1-class-Processing">Processing...</h1>
            <p class="p-class">Transaction has been sent to bank.<br />Processing From Bank!</p>
            <button class="btn_custom" onclick="goBack()">Go Back</button>
        </div>
    </div>
    @else
        <div style="text-align: center; padding: 40px 0;">
            <div class="card card-class">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="fail">!</i>
                </div>
                <h1 class="h1-class-fail">Fail</h1>
                <p class="p-class">Something went wrong Please try again;<br /></p>
                <button class="btn_custom" onclick="goBack()">Go Back</button>
            </div>
        </div>
    @endif

    <form name="member_signup" action="{{ $callbackUrl }}" method="post">
        @foreach ($postData as $key => $item)
            <input type="hidden" name="{{ $key }}" value="{{ $item }}">
        @endforeach
        <input type="submit" style="display: none;">
    </form>

    <script>
        function goBack() {
            document.forms['member_signup'].submit();
        }
        setTimeout(() => {
            document.forms['member_signup'].submit();
        }, 3000)
    </script>
</body>

</html>
