@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pengunjung Hari Ini</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Pengunjung</th>
                    <th>NPM</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visitors as $visitor)
                    <tr>
                        <td>{{ $visitor->npm }}</td>
                        <td>{{ $visitor->npm }}</td>
                        <td>{{ $visitor->visit_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
