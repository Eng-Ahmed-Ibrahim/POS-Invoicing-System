@extends("app")
@section('title','Products')

@section("content")

@section('create-button')
<button class="main-btn" data-bs-toggle="modal" data-bs-target="#add"><i class="fa-solid fa-plus mx-2"></i> Create Product</button>
@endsection
<div class="card">
    <div class="card-body">


        <div class="search-bar">
            <b>products</b>
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
                        <th>price</th>
                        <th>Dimensions</th>
                        <th>Features</th>
                        <th>Weight</th>
                        <th>Volume</th>
                        <th>image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>

                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->dimensions}}</td>
                        <td>{{$product->features}}</td>
                        <td>{{$product->weight}}</td>
                        <td>{{$product->volume}}</td>
                        <td><img src="{{asset($product->image)}}" style="height:70px" alt=""></td>
                        <td>
@php 
// In your Blade template, ensure the features are correctly escaped for JavaScript
$featuresEscaped = addslashes(preg_replace('/\r\n|\r|\n/', '\\n', $product->features));

@endphp
                        <i data-bs-toggle="modal" data-bs-target="#edit"
   onclick="setData(
       '{{ addslashes($product->id) }}',
       '{{ addslashes($product->name) }}',
       '{{ addslashes($product->price) }}',
       '{{ addslashes($product->category_id) }}',
       '{{ addslashes($product->dimensions) }}',
       '{{ addslashes($product->volume) }}',
       '{{ addslashes($product->weight) }}',
       '{{ addslashes($featuresEscaped) }}', 
       '{{ addslashes($product->image) }}'
   )"
   class="fa-solid fa-pen-to-square pointer">
</i>

                            <form action="{{route('products.destroy')}}" style="display: inline-block;" class="mx-2" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <button class="btn p-0">
                                    <i class="fa-solid fa-trash pointer" style="color: #ff0000;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links('vendor.pagination.custom') }}

        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="exampleModalLabel">Add product</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{route('products.store')}}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="mb-3 col">
                            <label for="name_" class="form-label"> Name</label>
                            <input type="text" class="form-control" name="name" id="name_" placeholder="product Name">
                        </div>
                        <div class="mb-3 col">
                            <label for="price_" class="form-label"> Price</label>
                            <input type="number" class="form-control" name="price" id="price_" placeholder="Price">
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="mb-3 col-lg-4 col-sm-6">
                            <label for="dimensions_" class="form-label"> Dimensions</label>
                            <input type="text" class="form-control" name="dimensions" id="dimensions_" placeholder="Dimensions">
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-6">
                            <label for="volume_" class="form-label"> Volume</label>
                            <input type="text" class="form-control" name="volume" id="volume_" placeholder="volume">
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label for="weight_" class="form-label"> Weight</label>
                            <input type="text" class="form-control" name="weight" id="weight_" placeholder="weight">
                        </div>

                    </div>
                    <div class="mb-3">
                        <select name="category_id" class="form-control" id="">
                            <option disabled selected>Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="features_">Features</label>
                        <textarea class="form-control" name="features" placeholder="features" id="features_"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_" class="form-label"> Image</label>
                        <input type="file" class="form-control" name="image" id="image_" placeholder="image">
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
                <h6 class="modal-title fs-5" id="exampleModalLabel">Edit product</h6>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{route('products.update')}}" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" name="product_id" id="product_id">
                <div class="modal-body">
                    <div class="row">

                        <div class="mb-3 col">
                            <label for="name" class="form-label"> Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="product Name">
                        </div>
                        <div class="mb-3 col">
                            <label for="price" class="form-label"> Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Price">
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="mb-3 col-lg-4 col-sm-6">
                            <label for="dimensions" class="form-label"> Dimensions</label>
                            <input type="text" class="form-control" name="dimensions" id="dimensions" placeholder="Dimensions">
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-6">
                            <label for="volume" class="form-label"> Volume</label>
                            <input type="text" class="form-control" name="volume" id="volume" placeholder="volume">
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label for="weight" class="form-label"> Weight</label>
                            <input type="text" class="form-control" name="weight" id="weight" placeholder="weight">
                        </div>

                    </div>
                    <div class="mb-3">
                        <select name="category_id" class="form-control" id="category_id">
                            <option disabled selected>Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="features">Features</label>

                        <textarea class="form-control"  name="features" placeholder="features" id="features"></textarea>
                    </div>
                    <div class="mb-3">
                        <img src="" id="img" style="height: 70px;" alt="">
                        <label for="image" class="form-label"> Image</label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="image">
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
    function setData(id, name, price, category_id, dimensions, volume, weight, features, image) {
        console.log({ id, name, price, category_id, dimensions, volume, weight, features, image });
        
        // Set hidden input product ID
        document.getElementById('product_id').value = id;

        // Set name input
        document.getElementById('name').value = name;

        // Set price input
        document.getElementById('price').value = price;

        // Set category dropdown
        document.getElementById('category_id').value = category_id;

        // Set description
        document.getElementById('weight').value = weight;
        document.getElementById('volume').value = volume;
        document.getElementById('dimensions').value = dimensions;

        document.getElementById('features').value = features.replace(/\\n/g, '\n'); // Replace JavaScript escape sequences
        document.getElementById('img').src = image; // Assuming 'image' is a URL
    }
</script>
@endsection