<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INV-#{{$invoice->id}}</title>
    <style>
        body {
            font-family:  'DejaVu Sans', 'XBRiyaz', sans-serif;
            color: #4e5e6a;
            margin: 0;
            padding: 0;
        }

        /* .invoices {
            padding: 30px;
        } */

        .invoice-left {
            float: left;
            width: 67%;
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
            background-color: rgba(98, 150, 212, 1);
            color: #fff;
            margin: 10px 0;
            display: inline-block;
            ;
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



        th {
            background-color: rgba(98, 150, 212, 1);
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
            background-color: rgba(98, 150, 212, 1);
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

        th,
        td {
            font-size: 12px;
            border: 1px solid #eee;
            padding: 5px;
            text-align: center;
        }

        th {
            color: white !important;
        }
    </style>
</head>

<body>
    <section class="invoices">
        <div class="invoice-left">
            <img src="{{request()->getSchemeAndHttpHost()}}/assets/static/logo.png" alt="Company Logo">

            <div class="text-bold" style="margin-top: 10px;">Concord Home Appliances</div>
            <div>Phone: +961 76 622 149</div>
            <!-- <div>Email: info@concord.com</div> -->
            <div>Website: <a href="https://concordonlinestore.com/" target="_blank" style="color: #4e5e6a;">concordonlinestore.com</a></div>
            <div style="margin-top: 10px;">
                <div style="margin: 0;"> <b>Bill To</b></div>
                <div style="margin: 0;"><strong>{{$invoice->client->name}}</strong></div>
                <p>{{$invoice->client->address}}</p>

            </div>
        </div>
        <div class="invoice-right">
            <div class="text-right">
                <div class="invoice-info-title"> &nbsp;INV #{{ $invoice->id }} &nbsp;</div>
                <div>  Date : {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</div>
                <div>
                    <img src="{{request()->getSchemeAndHttpHost()}}/{{$invoice->items[0]->image}}" style="height:auto;width:216px;" alt="">
                </div>
            </div>

        </div>
        <div style="clear: both;"></div>
        <div class="w-100">

            <table class="w-100">
                <thead>
                    <tr style="font-weight: bold; color: rgb(78, 94, 106); border-bottom: 1px solid #eee; border-top: 1px solid #eee;">
                        <th>Model number</th>
                        <th>Image</th>
                        <th>Volume</th>
                        <th>Dimensions</th>
                        <th>Features</th>
                        <th>Weight</th>
                        <th>USD without VAT</th>
                        <th>USD with VAT</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total=0;
                    @endphp
                    @foreach($invoice->items as $item)
                    @php
                    $total += $item->total;
                    @endphp
                    <tr>
                        <td>{{$item->model_number}}</td>
                        <td><img src="{{request()->getSchemeAndHttpHost()}}/{{$item->image}}" style="height:50px;" alt=""> </td>
                        <td>{{$item->volume}}</td>
                        <td>{{$item->dimensions}}</td>
                        <td style="font-size: 10px;">{{$item->features}}</td>
                        <td>{{$item->weight}}</td>
                        <td>{{$item->without_vat}}$</td>
                        <td>{{$item->with_vat  > 0 ? $item->with_vat. "$" : ' '}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->total}}$</td>
                    </tr>
                    @endforeach
                    <tr>
                            <td colspan="9" style="text-align: right;">Total</td>
                            <td style="background-color: rgba(98, 150, 212, 1);color:white">{{ $total }}$</td>
                        </tr>
                </tbody>
            </table>
        </div>
        <div>
                <h3  class="mt-3 mb-2" > General Conditions</h3>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Origin of Goods: </b> Lebanon</div>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Brand Name: </b> Concord</div>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Payment: </b> Cash in US DOLLARS</div>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Note: </b>  TVA to be paid at Sayrafa Rate</div>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Full Waranty </b> For One Year</div>
                <div style="font-size: 12px;"><b style="font-size: 12px;">Delivery: </b> Depends on ordered quantity and desired model within 4 days after confirmaion of order</div>
            </div>
    </section>

</body>

</html>