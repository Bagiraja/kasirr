@extends('layouts.admin')

@section('content')
@include('components.editprdk')

 
    <div class="container">
        <div class="row justify-content-center">
  <div class="card p-4 w-50 " style="background-color: #B0E0E6; margin-top: 60px;">


    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


     
        <div class="mb-2">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="{{ old('kode_barang', $product->kode_barang) }}" required>
        </div>

        <div class="mb-2">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-2">
            <label for="image" class="form-label">Image</label>
            @if ($product->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="70">
            </div>
            @endif
            <input type="file" class="form-control" name="image" id="image" >
        </div>

        <div class="mb-2">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Update</button>
    </form>
  </div>
        </div>
  </div>
@endsection
