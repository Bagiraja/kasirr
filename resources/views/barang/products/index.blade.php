@extends('layouts.barang')

@section('content')
<style>
    .container{
        overflow-y: auto;
        height: 50%;
    }
</style>

    <h4 class="mt-5 fw-bold">Daftar Produk</h4>
    <a href="{{ route('barang.products.create') }}" class="btn btn-primary mb-3 mt-2">Tambah Produk</a>

    <form class="d-flex mb-4">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="src">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="container">
    <div class="card p-4" style="background-color: #B0E0E6;">
    <table class="table table-bordered mt-3" style="background-color: white;">
        <thead>
            <tr>
                <th>KodeBarang</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->kode_barang }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('barang.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('barang.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


@endsection
