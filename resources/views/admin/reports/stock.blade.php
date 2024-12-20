@extends('layouts.admin')

@section('content')
<style>
    .stock-container {
        background-color: #00328E;
        border-radius: 15px;
        padding: 25px;
        margin-top: 30px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .stock-table {
        background-color: white;
        border-radius: 8px;
    }

    .stock-image {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .stock-container {
            padding: 15px;
            margin-top: 20px;
        }

        .table-responsive {
            margin: 0 -15px;
            overflow-x: auto;
        }

        .stock-image {
            width: 50px;
            height: 50px;
        }

        .pagination {
            font-size: 12px;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .stock-image {
            width: 40px;
            height: 40px;
        }

        .table th, .table td {
            padding: 8px;
        }

        .table thead {
            font-size: 14px;
        }
    }
</style>

<div class="container-fluid ">
    <h4 class="mt-4">Laporan Stock</h4>
    <div class="row mb-4">
        <div class="col-12">
            <form action="{{ route('admin.search.stock') }}" method="GET" class="d-flex gap-2">
                <input class="form-control" name="search" type="search" 
                       placeholder="Search products..." value="{{ old('search', $search ?? '') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="stock-container">
        <div class="table-responsive">
            <table class="table table-bordered table-hover stock-table p-2">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Stock</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr>
                            <td class="text-center">{{ $stock->id }}</td>
                            <td>{{ $stock->name }}</td>
                            <td class="text-center">
                                @if ($stock->image)
                                    <img src="{{ asset('storage/' . $stock->image) }}" 
                                         alt="{{ $stock->name }}" 
                                         class="stock-image">
                                @endif
                            </td>
                            <td class="text-center">{{ $stock->stock }}</td>
                            <td class="text-end">
                                Rp{{ number_format($stock->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No stocks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav aria-label="...">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $stocks->onFirstPage() ? 'disabled' : '' }}">
                    <span class="page-link" href="{{ $stocks->previousPageUrl() }}">Previous</span>
                </li>
                @for ($i = 1; $i <= $stocks->lastPage(); $i++)
                    <li class="page-item {{ $stocks->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $stocks->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ !$stocks->hasMorePages() ? 'disabled' : '' }}">
                    <span class="page-link" href="{{ $stocks->nextPageUrl() }}">Next</span>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection
