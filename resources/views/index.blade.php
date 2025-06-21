@extends("app")
@section('title','Overview')
@section("content")
<div class="tabs-container ">
    <div class="tabs">
        @foreach($categories as $category)
        <div  onclick="location.href='?category_id={{$category->id}}'" class="tab {{request('category_id')  == $category->id ? 'active' : ' '}}">{{$category->name}}</div>
        @endforeach

    </div>
</div>





<div class="products  row mt-5">
    @if(count($products) > 0)
    @foreach($products as $product)
    <div class="card product mb-4 col-lg-4 col-md-6 col-sm-12">
        <div class="card-body">
            <div class="product-image text-center">
                <img src="{{asset($product->image)}}" style="height:216px" alt="">
            </div>
            <h4 class="product-title mt-2">{{$product->name}}</h4>
            <div class="description text-muted">
                Volume {{$product->volume}},{{$product->dimensions}}
            </div>
            <h4 class="product-features">Features</h4>
            <div class="text-muted" style="white-space: pre-wrap;">{{$product->features}}</div>
        </div>
    </div>
    @endforeach
    @else 
    <div class="text-center card col-12"> <div class="card-body text-center  ">No Data</div> </div>
    @endif
    <div class="col-12">

        {{ $products->links('vendor.pagination.custom') }}
    </div>

</div>
@endsection