@extends('Products.layout')

@section('content')

<div class = "container" style="padding-top: 12%">
    <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <a href={{route('product.index')}}>back</a>
          <p class="card-text">Product Name : {{$product->name}}</p>
        </div>
      </div>
</div>



<div class="container" style="padding-top : 2%">

    <form action="{{route('product.update',$product->id)}}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
          <label for="exampleFormControlInput1"> Name </label>
          <input type="text" name="name" value="{{$product->name}}" class="form-control"  placeholder="product name">
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1"> Price </label>
            <input type="text" name="price" value="{{$product->price}}" class="form-control"  placeholder="product price">
          </div>

        <div class="form-group">
          <label for="exampleFormControlTextarea1">Details </label>
          <textarea class="form-control" name="details" rows="3">
            {{$product->details}}
          </textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">update</button>
        </div>
      </form>

</div>



@endsection
