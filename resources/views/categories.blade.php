@extends("app")
@section('title','Categories')

@section("content")

@section('create-button')
<button class="main-btn" data-bs-toggle="modal" data-bs-target="#add"><i class="fa-solid fa-plus mx-2"></i> Create Category</button>
@endsection
<div class="card">
    <div class="card-body">


        <div class="search-bar">
            <b>Categories</b>
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
                        <!-- <th>Number of products</th> -->
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <!-- <td>{{$category->products_count }}</td> -->
                        <td>{{ $category->created_at->format('M d, Y') }}
                        </td>
                        <td>

                            <i data-bs-toggle="modal" data-bs-target="#edit" onclick="setData('{{$category->id}}','{{$category->name}}')" class="pointer fa-solid fa-pen-to-square"></i>
                            <form action="{{route('categories.destroy')}}" style="display: inline-block;" class="mx-2" method="post">
                                @csrf
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <button class="btn p-0">
                                    <i class="fa-solid fa-trash pointer" style="color: #ff0000;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Add category</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{route('categories.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" id="name_" placeholder="Category Name">
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
                <h6 class="modal-title fs-5" id="exampleModalLabel">Edit category</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{route('categories.update')}}" method="post">
                @csrf
                <input type="hidden" name="category_id" id="category_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Category Name">
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
    function setData(id,name){
        document.getElementById("category_id").value=id
        document.getElementById("name").value=name
    }
</script>
@endsection