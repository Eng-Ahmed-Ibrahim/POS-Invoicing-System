@extends('app')
@section('title', ($invoice->is_invoice ? 'Invoice' : 'Quotation') . ' Details')
@section('css')

    <style>
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

        th,
        td {
            border: 1px solid #eee;
            padding: 5px;
            text-align: center;
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

        .download-btn {
            border-radius: 8px;
            background: rgba(98, 150, 212, 1);
            padding: 8px 10px;
            border: none;
            outline: none;
            color: white;
        }

        th {
            color: white !important;
        }
    </style>
@endsection
@section('create-button')
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle mx-2" style="border-radius:140px;padding: 8px 10px 8px 10px;"
            type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Change Status
        </button>
        <ul class="dropdown-menu">
            @if ($invoice->is_invoice)
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 0]) }}">
                        Unpaid
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 1]) }}">
                        Partially Paid
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 2]) }}">
                        Paid
                    </a>
                </li>
            @else
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 3]) }}">
                        Pending
                    </a>
                </li>
                <li><a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 4]) }}">
                        Accepted
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 5]) }}">
                        Rejected
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 6]) }}">
                        Converted to Invoice
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <button class="main-btn" data-bs-toggle="modal" data-bs-target="#add"><i class="fa-solid fa-plus mx-2"></i> Add
        Item</button>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <section class="invoices">
                <div class="invoice-left">
                    <img src="{{ request()->getSchemeAndHttpHost() }}/assets/static/logo.png" alt="Company Logo">

                    <div class="text-bold" style="margin-top: 10px;">Concord Home Appliances</div>
                    <div>Phone: +961 76 622 149</div>
                    <!-- <div>Email: info@concord.com</div> -->
                    <div>Website: <a href="https://concordonlinestore.com/"
                            style="color: #4e5e6a;">concordonlinestore.com</a></div>
                    <div style="margin-top: 10px;">
                        <div style="margin: 0;"> <b>Bill To</b></div>
                        <div style="margin: 0;"><strong>{{ $invoice->client->name }}</strong></div>
                        <p>{{ $invoice->client->address }}</p>

                    </div>
                </div>
                <div class="invoice-right">
                    <div class="text-right">
                        <div class="invoice-info-title">&nbsp;
                            {{ $invoice->is_invoice ? "#INV-$invoice->id" : "#QTN-$invoice->id" }} &nbsp;</div>
                        @if (count($invoice->items) > 0)
                            <div>Date : {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</div>
                            <div>
                                <img src="/{{ $invoice->items[0]->image }}" style="height:auto;width:216px;"
                                    alt="">
                            </div>
                        @endif
                    </div>

                </div>
                <div style="clear: both;"></div>
                <div class="w-100">

                    <table class="w-100">
                        <thead>
                            <tr
                                style="font-weight: bold; color: white; border-bottom: 1px solid #eee; border-top: 1px solid #eee;">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($invoice->items) > 0)
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($invoice->items as $item)
                                    @php
                                        $total += $item->total;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->model_number }}</td>
                                        <td><img src="{{ asset($item->image) }}" style="height:100px;" alt="">
                                        </td>
                                        <td>{{ $item->volume }}</td>

                                        <td>{{ $item->dimensions }}</td>
                                        <td>{{ $item->features }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>{{ $item->without_vat }}$</td>
                                        <td>{{ $item->with_vat > 0 ? $item->with_vat . "$" : ' ' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->total }}$</td>
                                        <td>
                                            <form action="{{ route('invoice.delete_item', $item->id) }}" method="post">
                                                @csrf

                                                <button class="btn" type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this Item?');">
                                                    <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="9" style="text-align: right;">Total</td>
                                    <td style="background-color: rgba(98, 150, 212, 1);color:white">{{ $total }}$
                                    </td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="11" class="text-center"> No Products</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div>
                    <h3 class="mt-3 mb-2"> General Conditions</h3>
                    <div style="font-size: 15px;"><b style="font-size: 15px;">Origin of Goods: </b> Lebanon</div>
                    <div style="font-size: 15px;"><b style="font-size: 15px;">Brand Name: </b> Concord</div>
                    <div style="font-size: 15px;"><b style="font-size: 15px;">Payment: </b> Cash in US DOLLARS</div>
                    <div style="font-size: 15px;"><b style="font-size: 15px;">Delivery: </b>
                        {{ $invoice->is_invoice ? 'Within 4 working days' : 'Within 4 days after confirmation' }}</div>
                    @if ($invoice->is_invoice)
                        <div style="font-size: 15px;"><b style="font-size: 15px;">Full Waranty </b> For One Year</div>
                    @else
                        <div style="font-size: 15px;"><b style="font-size: 15px;"> TVA: </b> To be paid at Sayrafa Rate
                        </div>
                        <div style="font-size: 15px;"><b style="font-size: 15px;">Note: </b> This is a quotation, not an
                            official invoice.</div>
                    @endif
                </div>

            </section>
        </div>
    </div>
    <div class="card my-4 ">
        <div class="card-body p-3">
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <b>Client</b> : {{ $invoice->client->name }}
                    </div>
                    <div>
                        <b>Status</b> : @if ($invoice->status == 0)
                            Unpaid
                        @elseif($invoice->status == 1)
                            Partially Paid
                        @elseif($invoice->status == 2)
                            Paid
                        @endif
                    </div>
                </div>
                @if (count($invoice->items) > 0)
                    <div class="col-lg-6" style="text-align: right;">
                        <a href="{{ route('invoices.download_pdf', $invoice->id) }}" class="download-btn">Download
                            {{ $invoice->is_invoice ? 'Invoice' : 'Quotation' }}</a>
                    </div>
                @else
                    <div class="col-lg-6" style="text-align: right;">
                        <button class="download-btn" data-bs-toggle="modal" data-bs-target="#add"><i
                                class="fa-solid fa-plus mx-2"></i> Add an item to be able to download the invoice</button>

                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Add Item</h6>
                    <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('add_item') }}" method="post">
                    @csrf
                    <input type="text" hidden name="client_id" value="{{ $invoice->client->id }}">
                    <input type="text" hidden name="invoice_id" value="{{ $invoice->id }}">
                    <div class="modal-body">
                        <div class="row">

                            <div class="mb-3 col-12">
                                <label for="products" class="form-label">Product</label>
                                <div class="form-group w-100">
                                    <select onchange="updatePrice()" required style="width: 100% !important;"
                                        name="product_id" class="selectpicker" data-live-search="true">
                                        <option value="" selected disabled>Products</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input required type="number" class="form-control" name="quantity" id="Quantity"
                                    placeholder="Quantity">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="without_vat" class="form-label">USD Without VAT</label>
                                <input required type="without_vat" class="form-control" name="without_vat"
                                    id="without_vat" placeholder="USD Without VAT">
                            </div>
                            <div class="mb-3 col">
                                <label for="with_vat" class="form-label">USD With VAT</label>
                                <input type="with_vat" class="form-control" name="with_vat" id="with_vat"
                                    placeholder="USD With VAT">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function updatePrice() {
            // Get the selected option
            let quantity = document.getElementById('Quantity').value;
            const selectElement = document.querySelector('select[name="product_id"]');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            quantity = isNaN(quantity) || quantity === '' ? 1 : parseFloat(quantity);

            // Get the price from the data-price attribute
            const price = selectedOption.getAttribute('data-price');

            // Update the without_vat input field
            document.getElementById('without_vat').value = price ? (price) : ''; // Set to price or empty if no price
        }
    </script>
@endsection
