
// ranking.blade.php (view untuk menampilkan rangking)
@extends('layouts.app')

@section('content')
    <h1>Rangking</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Nilai</th>
        </tr>
        @foreach ($scores as $score)
            <tr>
                <td>{{ $score->nama }}</td>
                <td>{{ $score->nilai }}</td>
            </tr>
        @endforeach
    </table>
@endsection
