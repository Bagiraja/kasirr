<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.barang')

@section('content')
@include('components.dashboard')
<style>
    .card-body{
      border: 1px solid;
      border-radius: 7px ;
      background-color: #B0E0E6;
    }

    .card h5,p{
      color: white;
    }
</style>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="row row-cols-1 row-cols-md-4 g-2 mt-5">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-center mt-2">0</h5>
          <p class="card-text mt-4 d-flex justify-content-center">Stok</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-center mt-2">0</h5>
          <p class="card-text mt-4 d-flex justify-content-center">Jumlah Pengguna</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-center mt-2">0</h5>
          <p class="card-text d-flex justify-content-center mt-4">Jumlah Transaksi</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-center mt-2">0</h5>
          <p class="card-text mt-4 d-flex justify-content-center">Telah Terjual</p>
        </div>
      </div>
    </div>
@endsection
