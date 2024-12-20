@extends('layouts.kasir')

@section('content')
<div class="mt-4 ms-4">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #B0E0E6; border-radius:4px;">
        <div class="container-fluid">
           <p class="fs-4">Edit Produk</p>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card" style="background-color: #B0E0E6;">
                    <div class="card-body">
                        <form action="{{ route('kasir.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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

                            <div class="mb-3">
                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                <input type="text" id="kode_barang" name="kode_barang" class="form-control" value="{{ old('kode_barang', $product->kode_barang) }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Produk</label>
                                @if($product->image)
                                    <div>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock', $product->stock) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
                            </div>


                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
