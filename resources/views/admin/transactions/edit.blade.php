<!-- edit.blade.php -->
@extends('layouts.admin')

@section('content')
@include('components.edittrans')
    <div class="container">
         <div class="row justify-content-center">
        <div class="card p-4" style="background-color: #B0E0E6; width: 30vw; margin-top: 100px;">
        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select id="product_id" name="product_id" class="form-control">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $transaction->product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $transaction->quantity }}" required>
            </div> 
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ $transaction->price }}" required>
                <button type="submit" class="btn btn-primary w-100 mt-3">Update</button>
        </div>
            </div>
        </form>
    </div>
  
@endsection
