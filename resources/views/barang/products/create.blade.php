@extends('layouts.barang')

@section('content')
<div class="mt-4 ms-4">
    <h4 style="">Tambah Produk</h4>
    <form action="{{ route('barang.products.store') }}" method="POST" class="mt-4">
        @csrf
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="card p-4" style="background-color: #B0E0E6;">  
        <div class="mb-3">
            <label for="kode_barang" class="form-label">KodeBarang</label>
            <input type="text" id="kode_barang" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
    </form>
</div>
@endsection
