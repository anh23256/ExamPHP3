@extends('welcome')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success') && session()->get('success') == false)
            <div class="alert alert-danger" role="alert">
                Thao tác lỗi
            </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-4 col-form-label text-capitalize">name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" />
                </div>
            </div>
            <div class="mb-3 row">
                <label for="price" class="col-4 col-form-label text-capitalize">price</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}" />
                </div>
            </div>
            <div class="mb-3 row">
                <label for="quantity" class="col-4 col-form-label text-capitalize">quantity</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="quantity" id="quantity"
                        value="{{ old('quantity') }}" />
                </div>
            </div>
            <div class="mb-3 row">
                <label for="image" class="col-4 col-form-label text-capitalize">image</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="image" id="image" value="{{ old('image') }}" />
                </div>
            </div>
            <div class="mb-3 row">
                <label for="description" class="col-4 col-form-label text-capitalize">description</label>
                <div class="col-8">
                    <textarea name="description" class="form-control" cols="30" rows="10">
                        {{ old('description') }}
                    </textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label text-capitalize">is_active</label>
                <div class="col-8">
                    <input type="checkbox" class="form-checkbox" name="is_active" id="is_active" value="1" />
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
