<!DOCTYPE html>
<html>
    <head>
        <title>Honda Prima Maintenance</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #2B2B2B;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            .content a{
                color: #65f442;
                text-decoration: none;
                font-size: 30px;
                font-weight: bold;
            }
            .content a:hover{
                color: #B0BEC5;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Your Prepayment more than {{ $memo }}</div>
                <a href="{{ route('memo.prepayment.index') }}?finish=true">
                    Please Claim Your Memo Prepayment First
                </a>
            </div>
        </div>
    </body>
</html>
