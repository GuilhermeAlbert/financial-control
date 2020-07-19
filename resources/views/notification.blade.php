<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <title>Operation Notification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            outline: 0;
            box-sizing: border-box;
        }

        html,
        body,
        #root {
            min-height: 100%;
        }

        body {


            -webkit-font-smoothing: antialiased !important;
        }

        .container {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%)
        }

        .margin {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container" align="center">
        <header>
            <div class="row">
                <div class="col-md-12 margin">
                    <h1>Your transaction information</h1>
                </div>
            </div>
        </header>
        <main>
            <div class="row">
                <div class="col-md-12 margin">
                    <img src="images/invoice.svg" alt="Invoice" width="350px" draggable="false">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <h4 class="margin">Your {{ $transaction->key }} was done</h4>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="margin">
                                <td>Transaction type</td>
                                <td>Transaction name</td>
                                <td>Price</td>

                                @if($sourceAccount)
                                <td>Origin account</td>
                                @endif

                                @if($destinationAccount)
                                <td>Destination account</td>
                                @endif
                            </tr>
                            <tr>

                                <td>{{ ucwords($transaction->key) }}</td>
                                <td>{{ $extract->name }}</td>
                                <td>{{ $extract->current_balance }}</td>

                                @if($sourceAccount)
                                <td>{{ $sourceAccountUser->name }} ({{ $sourceAccount->name }})</td>
                                @endif

                                @if($destinationAccount)
                                <td>{{ $destinationAccountUser->name }} ({{ $destinationAccount->name }})</td>
                                @endif

                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </main>
        <footer class="margin">
            <div class="row">
                <div class="col-md-12">
                    &copy; Financial Control.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>