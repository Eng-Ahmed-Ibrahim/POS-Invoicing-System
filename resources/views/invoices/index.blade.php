@extends('app')
@section('title', $is_invoice ? 'Invoices' : 'Quotations')
@section('content')
@section('create-button')
    <button class="main-btn" data-bs-toggle="modal" data-bs-target="#add"><i class="fa-solid fa-plus mx-2"></i> Create
        {{ $is_invoice ? 'an' : 'a' }} {{ $is_invoice ? 'Invoices' : 'quotation' }}</button>
@endsection
<div class="card">
    <div class="card-body">


        <div class="search-bar">
            <b>{{ $is_invoice ? 'Invoices' : 'Quotation' }}</b>
            <form  class="d-flex">
                <input type="search" name="search" placeholder="search..." value="{{ request('search') }}">
                @if(! $is_invoice)

                <input type="hidden" name="quotation" value="all" >
                @endif
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>


        </div>

        <div class="section-table">
            <table>
                <thead>
                    <tr>
                        <th>{{ $is_invoice ? 'Invoices' : 'Quotation' }} ID</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>USD without VAT</th>
                        <th>USD with VAT</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td><a style="color:blue"
                                    href="{{ route('invoices.show', $invoice->id) }}"> {{ $invoice->is_invoice ? "#INV-$invoice->id" : "#QTN-$invoice->id" }}</a></td>
                            <td>{{ $invoice->client->name }}</td>
                            @if (count($invoice->items) > 0)
                                <td>{{ $invoice->items[0]['model_number'] }}</td>
                                <td>{{ $invoice->items[0]['quantity'] }}</td>
                                <td> {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</td>
                                <td>{{ $invoice->items[0]['without_vat'] }}</td>
                                <td>{{ $invoice->items[0]['with_vat'] }}</td>
                            @else
                                <td colspan="5"> No Product </td>
                            @endif
                            <td>
                                @if ($invoice->status === 0)
                                    <span class="badge bg-danger" style="color:white">Unpaid</span>
                                @elseif ($invoice->status === 1)
                                    <span class="badge bg-warning text-dark" style="color:white">Partially Paid</span>
                                @elseif ($invoice->status === 2)
                                    <span class="badge bg-success" style="color:white">Paid</span>
                                @elseif ($invoice->status === 3)
                                    <span class="badge bg-info" style="color:white">Pending</span>
                                @elseif ($invoice->status === 4)
                                    <span class="badge bg-success" style="color:white">Accepted</span>
                                @elseif ($invoice->status === 5)
                                    <span class="badge bg-success" style="color:white">Rejected</span>
                                @elseif ($invoice->status === 6)
                                    <span class="badge bg-success" style="color:white">Converted to Invoice</span>
                                @endif
                            </td>

                            <td>
                                <div style="display: flex; align-items:center;justify-content: center;">

                                    <form class="mx-1" action="{{ route('invoice.delete', $invoice->id) }}"
                                        method="post">
                                        @csrf

                                        <button class="btn" type="submit"
                                            onclick="return confirm('Are you sure you want to delete this invoice?');">
                                            <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                                        </button>
                                    </form>
                                    <a style="color:blue" href="{{ route('invoices.show', $invoice->id) }}"><i
                                            class="fa-solid fa-eye mx-2"></i></a>

                                    @if (! $invoice->is_invoice )
                                    <a  href="{{ route('invoices.updateStatus', ['invoice_id' => $invoice->id, 'status' => 6]) }}" class="btn btn-sm btn-secondary" >
                                        Converted to Invoice
                                    </a>
                              
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $invoices->links('vendor.pagination.custom') }}


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Create An
                    {{ $is_invoice ? 'Invoice' : 'Quotation' }}</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{ route('add_invoice') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $is_invoice ? 1 : 0 }}" name="is_invoice">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="clients" class="form-label">Client</label>
                            <div class="form-group w-100">

                                <select required name="client_id" class="selectpicker" data-live-search="true">
                                    <option value="" selected disabled>clients</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
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
                            <input required value="1" type="number" class="form-control" name="quantity"
                                id="Quantity" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="Date" class="form-label">Date</label>
                            <input required value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" type="date"
                                class="form-control" name="date" id="Date" placeholder="Date">
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
