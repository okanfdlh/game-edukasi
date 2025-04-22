@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pengunjung Hari Ini</h1>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('admin.visitors.filter') }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-auto">
                    <label for="tanggal" class="form-label">Filter Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mt-2">Tampilkan</button>
                </div>
            </div>
        </form>
        
        

        <table class="table table-bordered">
            <thead>
                <tr>
                    {{-- <th>Nama Pengunjung</th> --}}
                    <th>NPM</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visitors as $visitor)
                    <tr>
                        {{-- <td>{{ $visitor->nama }}</td> --}}
                        <td>{{ $visitor->npm }}</td>
                        <td>{{ $visitor->visit_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
