@extends('Products.layout')

@section('content')
<div class="jumbotron container">
    <p>Trashed Products</p>
    <a class="btn btn-primary btn-lg" href="{{route('product.index')}}" role="button">Home</a>
  </div>


  <div class = "container">
    <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Product Price</th>
            <th scope="col" style="width: 400px">Actions</th>
          </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @foreach ($products as $item)
            <tr>
                <th scope="row">{{++$i}}</th>
                <td>{{$item->name}}</td>
                <td>{{$item->price}}  SYR </td>
                <td>
                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-success" href="{{route('product.edit', $item->id)}}"> Edit</a>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-primary" href="{{route('product.show', $item->id)}}"> Show</a>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-warning" href="{{route('soft.delete', $item->id)}}"> Soft Delete</a>
                        </div>
                        <div class="col-sm">
                            <form action="{{route('product.destroy' , $item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                      </div>

                </td>
              </tr>

            @endforeach

        </tbody>
      </table>
      {{$products->links()}}
  </div>
@endsection
