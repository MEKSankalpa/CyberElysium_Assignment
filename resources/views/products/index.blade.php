@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">

            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>image</th>
            <th>Name</th>
            <th>Details</th>

            <th>price</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ ++$i }}</td>
                <td> <img src="{{ asset('/Image/'.$product->image) }}" width="200" height="200"> </td>

                <td>{{ $product->name }}</td>
                <td>{{ $product->detail }}</td>
                <td>{{ $product->price }}</td>

                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>

{{--                        <a class="btn btn-primary" href="{{ route('products.edit',$products->id) }}">Detail set as Null</a>--}}

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>



                    </form>
                </td>
            </tr>
        @endforeach
    </table>
   </div>

    {!! $products->links() !!}

@endsection
