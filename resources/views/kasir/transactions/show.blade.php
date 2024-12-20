@extends('layouts.kasir')

@section('content')
<style>
  body{
    overflow-y: auto;
  }
</style>
<div class="container-fluid py-4">
    <h4 class="">Riwayat Transaksi</h4>
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-8">
            <form action="{{ route('admin.transactions.search') }}" method="GET" class="d-flex gap-2">
                <input class="form-control" name="search" type="search" 
                       placeholder="Search products..." value="{{ old('search', $search ?? '') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
        <div class="col-12 col-md-4 mt-3 mt-md-0 text-md-end">
            <a href="{{ route('admin.transactions.pdf') }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Download PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body" style="background-color: white;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Qty</th>
                            <th>Price/Unit</th>
                            <th>Total</th>
                            <th>Cash</th>
                            <th>Change</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->product->name }}</td>
                                <td>
                                    @if($transaction->product->image)
                                        <img src="{{ asset('storage/' . $transaction->product->image) }}" alt="{{ $transaction->product->image }}" width="100">
                                    @endif
                                  </td>
                                <td>{{ $transaction->quantity }}</td>
                                <td>Rp{{ number_format($transaction->price, 2) }}</td>
                                <td>Rp{{ number_format($transaction->total, 2) }}</td>
                                <td>Rp{{ number_format($transaction->cash_received, 2) }}</td>
                                <td>Rp{{ number_format($transaction->change, 2) }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    <div class="d-flex flex-column flex-md-row gap-2">
                                        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" 
                                           class="btn btn-warning btn-sm">Edit</a>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                           class="btn btn-info btn-sm">Show</a>
                                        <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <nav aria-label="...">
                <ul class="pagination">
                  <li class="page-item {{ $transactions->onFirstPage() ? 'disabled' : ''}}">
                    <span class="page-link" href="{{ $transactions->previousPageUrl() }}">Previous</span>
                  </li>
        
                  @for ($i = 1; $i <= $transactions->lastPage(); $i++)
                  <li class="page-item {{ $i == $transactions->currentPage() ? 'active' : ''}}">
                    <a class="page-link" href="{{ $transactions->url($i) }}">{{ $i }}</a>
                  </li>
                  @endfor
                  <li class="page-item {{ $transactions->hasMorePages() ? 'disabled' : ''}}">
                    <span class="page-link" href="{{ $transactions->nextPageUrl() }}">Next</span>
                  </li>
                </ul>
              </nav>
        </div>
    </div>
</div>
@endsection