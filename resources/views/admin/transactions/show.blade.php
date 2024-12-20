@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4">Transaction Details</h1>
        <div class="card p-2 d-flex" style="width: 35vw; background-color: #B0E0E6">
        <dl class="row">
            <dt class="col-sm-3">ID :</dt>
            <dd class="col-sm-9">{{ $transaction->id }}</dd>
            
            <dt class="col-sm-3">Product :</dt>
            <dd class="col-sm-9">{{ $transaction->product->name }}</dd>
            
            <dt class="col-sm-3">Quantity :</dt>
            <dd class="col-sm-9">{{ $transaction->quantity }}</dd>
            
            <dt class="col-sm-3">Price :</dt>
            <dd class="col-sm-9">{{ $transaction->price }}</dd>
            
            <dt class="col-sm-3">Total :</dt>
            <dd class="col-sm-9">{{ $transaction->total }}</dd>

            <dt class="col-sm-3">Uang Tunai :</dt>
            <dd class="col-sm-9">{{ number_format($transaction->cash_received, 2) }}</dd>
            
            <dt class="col-sm-3">Kembalian :</dt>
            <dd class="col-sm-9">{{ number_format($transaction->change, 2) }}</dd>
            
            <dt class="col-sm-3">Created At :</dt>
            <dd class="col-sm-9">{{ $transaction->created_at }}</dd>
            
            <dt class="col-sm-3">Updated At :</dt>
            <dd class="col-sm-9">{{ $transaction->updated_at }}</dd>
        </dl>
        <a href="{{ route('admin.transactions.index') }}" class="btn" style="background-color: white;">Back to List</a>
    </div>
    </div>
@endsection
