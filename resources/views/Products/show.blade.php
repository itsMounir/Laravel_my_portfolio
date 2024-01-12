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

        <div class="form-group">
          <label for="exampleFormControlInput1"> {{ $product->name }} </label>
        </div>

        <div class="form-group">
            <label for="exampleFormControlInput1"> {{ $product->price }} </label>
          </div>

        <div class="form-group">
            {!! $product->details !!}
        </div>

</div>



@endsection
