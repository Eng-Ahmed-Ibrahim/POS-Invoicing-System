@extends("app")
@section('title','Clients')

@section("content")

@section('create-button')
<button class="main-btn" data-bs-toggle="modal" data-bs-target="#add"><i class="fa-solid fa-plus mx-2"></i> Add Client</button>
@endsection
<div class="card">
    <div class="card-body">


        <div class="search-bar">
            <b>Clients</b>
            <form class="d-flex">
                <input type="search" name="search" placeholder="search..." value="{{request('search')}}">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>


        </div>

        <div class="section-table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($clients) > 0 )
                    @foreach($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->address}}</td>
                        <td>

   <i data-bs-toggle="modal"
   data-bs-target="#edit"
   data-id="{{ $client->id }}"
   data-name="{{ e($client->name) }}"
   data-phone="{{ e($client->phone) }}"
   data-email="{{ e($client->email) }}"
   data-address="{{ e($client->address) }}"
   onclick="setDataFromElement(this)"
   class="pointer fa-solid fa-pen-to-square"></i>

                            <form action="{{route('clients.destroy')}}" style="display: inline-block;" class="mx-2" method="post">
                                @csrf
                                <input type="hidden" name="client_id" value="{{$client->id}}">
                                <button class="btn p-0">
                                    <i class="fa-solid fa-trash pointer" style="color: #ff0000;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else  
                    <tr>
                        <td colspan="6" class="text-center">No Date</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{ $clients->links('vendor.pagination.custom') }}

        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Add client</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{route('clients.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="name_" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name_" placeholder="Name">
                        </div>
                        <div class="mb-3 col">
                            <label for="phone_" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone_" placeholder="Phone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="email_" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email_" placeholder="email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address_">Address</label>
                        <textarea class="form-control" name="address" placeholder="Address" id="address_"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title " style="font-size:16px" id="exampleModalLabel">Edit client</h1>
                <button type="button" class="btn-close btn" style="font-size: 24px;" data-bs-dismiss="modal" aria-label="Close">    &times; <!-- × symbol --></button>
            </div>
            <form action="{{route('clients.update')}}" method="post">
                @csrf
                <input type="hidden" name="client_id" id="client_id">
                <div class="modal-body">
                <div class="row">
                        <div class="mb-3 col">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="mb-3 col">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" placeholder="Address" id="address"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function setDataFromElement(el) {
        document.getElementById("client_id").value = el.dataset.id;
        document.getElementById("name").value = el.dataset.name;
        document.getElementById("phone").value = el.dataset.phone;
        document.getElementById("email").value = el.dataset.email;
        document.getElementById("address").value = el.dataset.address;
    }
</script>

@endsection