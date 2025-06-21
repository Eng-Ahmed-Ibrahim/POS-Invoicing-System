<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INV #11</title>
    <link rel="icon" href="{{asset('assets/static/logo.png')}}">

    <style>
        body {
            font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #4e5e6a;
            margin: 0;
            padding: 0;
        }

        .invoices {
            padding: 30px;
        }

        .invoice-left {
            float: left;
            width: 68%;
            padding-right: 20px;
        }

        .invoice-right {
            float: left;
            width: 30%;
        }

        .invoice-left img {
            display: block;
        }

        .invoice-left div,
        .invoice-right div {
            margin-bottom: 10px;
        }

        .text-bold {
            font-size: 14px;
            font-weight: bold;
            color: rgb(78, 94, 106);
        }

        .invoice-info-title {
            padding: 5px;
            font-size: 20px;
            font-weight: bold;
            background-color:rgba(98, 150, 212, 1);
            color: #fff;
            margin: 10px 0;
            display: inline-block;;
            border-radius: 8px;
        }

        .text-right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        th, td {
            border: 1px solid #eee;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color:rgba(98, 150, 212, 1);
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .total-paid {
            background-color: #f4f4f4;
        }

        .total-remaining {
            background-color:rgba(98, 150, 212, 1);
            color: #fff;
        }

        .main-btn-primary {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }

        .main-btn-primary i {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <section class="invoices">
        <div class="invoice-left">
            <img src="https://concordapi.mass-fluence.com/files/logo-black.png" alt="Company Logo">

            <div class="text-bold" style="margin-top: 10px;">Qudrability ELC</div>
            <div>Phone: +971 4 422 1294</div>
            <div>Email: info@concord.com</div>
            <div>Website: <a href="https://concord.mass-fluence.com/" style="color: #4e5e6a;">https://concord.mass-fluence.com/</a></div>
            <div style="margin-top: 10px;">
                <div style="margin: 0;"> <b>Bill To</b></div>
                <div style="margin: 0;"><strong>Ahmed Ebrahim</strong></div>
                <p>Address</p>
            </div>
        </div>
        <div class="invoice-right">
            <div class="text-right" >
                <div class="invoice-info-title">&nbsp;INV #1&nbsp;</div>
                <div>Due Date : 22</div>
                <div>
                    <img src="https://invoices.mass-fluence.com/files/17273501591727186774WhatsApp_Image_2024_09_16_at_8.19.52_PM.jpeg" style="height:208px;width:100%;" alt="">
                </div>
            </div>

        </div>
        <div style="clear: both;"></div>
        <table class="table-responsive">
            <thead>
                <tr style="font-weight: bold; color: rgb(78, 94, 106); border-bottom: 1px solid #eee; border-top: 1px solid #eee;">
                    <th style="width: 5%;">#</th>
                    <th style="width: 25%;">Payment Method</th>
                    <th style="width: 30%;">Payment Date</th>
                    <th style="width: 30%;">Amount</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </section>
</body>

</html>
