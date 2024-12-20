@extends('layouts.admin')





@section('content')

<style>
  

    .search-container {
        background: #00328E;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .table-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .product-image {
    width: 60px; /* Lebar gambar */
    height: 60px; /* Tinggi gambar */
    object-fit: cover; /* Potong gambar agar sesuai dengan dimensi */
    border-radius: 8px;
    transition: transform 0.3s;
}


    .product-image:hover {
       
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .product-container {
            margin-top: 70px;
        }

        .search-container {
            padding: 15px;
        }

        .product-image {
            width: 50px;
            height: 50px;
        }

        .table {
            font-size: 14px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
    }
</style>
<div class="container-fluid product-container">
    <h3 class="mt-4">Manajement Produk</h3>
    <div class="search-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <form action="{{ route('admin.search') }}" method="GET" class="d-flex gap-2">
                    <input class="form-control" name="search" type="search" 
                           placeholder="Search products..." 
                           value="{{ old('search', $search ?? '') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->kode_barang }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="product-image">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $product->stock > 10 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Tombol 'Previous' -->
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a>
                        </li>
    
                        <!-- Menampilkan nomor halaman -->
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
    
                        <!-- Tombol 'Next' -->
                        <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
