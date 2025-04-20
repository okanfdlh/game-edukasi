@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Soal Kuis</h1>

        <form action="{{ route('admin.updateQuestion', $question->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Jangan lupa method PUT untuk update -->
            
            <div class="form-group">
                <label for="jenis_soal">Jenis Soal:</label>
                <input type="text" name="jenis_soal" value="{{ old('jenis_soal', $question->jenis_soal) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pertanyaan">Soal:</label>
                <input type="text" name="pertanyaan" value="{{ old('pertanyaan', $question->pertanyaan) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pilihan">Pilihan:</label>
                <input type="text" name="pilihan[]" value="{{ old('pilihan.0', json_decode($question->pilihan_jawaban)[0]) }}" class="form-control" required>
                <input type="text" name="pilihan[]" value="{{ old('pilihan.1', json_decode($question->pilihan_jawaban)[1]) }}" class="form-control" required>
                <input type="text" name="pilihan[]" value="{{ old('pilihan.2', json_decode($question->pilihan_jawaban)[2]) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="jawaban_benar">Jawaban Benar:</label>
                <input type="number" name="jawaban_benar" value="{{ old('jawaban_benar', $question->jawaban_benar) }}" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Soal</button>
        </form>
        
    </div>
@endsection
