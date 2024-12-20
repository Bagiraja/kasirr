@extends('layouts.admin')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finances as $finance)
            <tr>
                <th>{{ $finance->id }}</th>
                <th>{{ $finance->description }}</th>
                <th>{{ $finance->amount }}</th>
                <th>{{ $finance->created_at->format('d-m-y') }}</th>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection