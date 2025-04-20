@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Soal Kuis</h1>

    <form action="{{ route('admin.createQuestion') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jenis_soal">Jenis Soal:</label>
            <select name="jenis_soal" id="jenis_soal" class="form-control" required>
                <option value="umum">1. Umum</option>
                <option value="matematika">2. Matematika</option>
                <option value="polmanbabel">3. Kampus Polman Babel</option>
            </select>
        </div>
        

        <div class="form-group">
            <label for="pertanyaan">Pertanyaan:</label>
            <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="pilihan">Pilihan Jawaban:</label>
            <input type="text" name="pilihan[]" class="form-control mb-1" placeholder="Pilihan 1" required>
            <input type="text" name="pilihan[]" class="form-control mb-1" placeholder="Pilihan 2" required>
            <input type="text" name="pilihan[]" class="form-control mb-1" placeholder="Pilihan 3" required>
        </div>

        <div class="form-group">
            <label for="jawaban_benar">Index Jawaban Benar (0, 1, 2...):</label>
            <input type="number" name="jawaban_benar" id="jawaban_benar" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Tambah Soal</button>
    </form>

    <h3 class="mt-5">Daftar Soal</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Pertanyaan</th>
                <th>Pilihan</th>
                <th>Jawaban Benar</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->jenis_soal }}</td>
                    <td>{{ $question->pertanyaan }}</td>
                    <td>
                        @php
                            $options = json_decode($question->pilihan_jawaban, true);
                        @endphp
                        @foreach ($options as $index => $option)
                            <div>{{ $index }}. {{ $option }}</div>
                        @endforeach
                    </td>
                    <td>
                        @if (isset($options[$question->jawaban_benar]))
                            {{ $question->jawaban_benar }}. {{ $options[$question->jawaban_benar] }}
                        @else
                            Tidak Valid
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.editQuestion', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.destroyQuestion', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
