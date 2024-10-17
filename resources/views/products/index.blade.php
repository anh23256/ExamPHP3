@extends('welcome')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm mới sản phẩm</a>
    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-danger" role="alert">
            Thao tác thành công
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col text-uppercase">id</th>
                    <th scope="col text-uppercase">name</th>
                    <th scope="col text-uppercase">description</th>
                    <th scope="col text-uppercase">price</th>
                    <th scope="col text-uppercase">quantity</th>
                    <th scope="col text-uppercase">is_active</th>
                    <th scope="col text-uppercase">image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->is_active }}</td>
                        <td><img src="{{ Storage::url($product->image) }}" class="img-fluid rounded-top" alt="" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
