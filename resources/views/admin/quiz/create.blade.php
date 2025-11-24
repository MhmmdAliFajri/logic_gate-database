@extends('layouts.master')
@section('title', 'Kuis')
@section('subtitle', 'Tambah')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('quiz', '')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Kuis</h5>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Periksa kembali!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.quiz.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-12">
                        <label for="title" class="form-label">Judul Kuis</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Daftar Pertanyaan</label>
                        <div id="questions-container">
                            <!-- Pertanyaan pertama -->
                            <div class="question-item border p-3 mb-3">
                                <strong class="d-block mb-2">#1</strong>
                                <div class="mb-2">
                                    <label>Pertanyaan</label>
                                    <input type="text" name="questions[0][question]" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label>Opsi A</label>
                                        <input type="text" name="questions[0][option_a]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Opsi B</label>
                                        <input type="text" name="questions[0][option_b]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Opsi C</label>
                                        <input type="text" name="questions[0][option_c]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Opsi D</label>
                                        <input type="text" name="questions[0][option_d]" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Opsi E</label>
                                        <input type="text" name="questions[0][option_e]" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Jawaban Benar</label>
                                        <select name="questions[0][correct_answer]" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-question" class="btn btn-sm btn-secondary">
                            + Tambah Pertanyaan
                        </button>
                    </div>

                    <div class="text-start mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.quiz.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        let questionIndex = 1;

        document.getElementById('add-question').addEventListener('click', function() {
            let container = document.getElementById('questions-container');

            let html = `
                <div class="question-item border p-3 mb-3">
                    <strong class="d-block mb-2">#${questionIndex + 1}</strong>
                    <div class="mb-2">
                        <label>Pertanyaan</label>
                        <input type="text" name="questions[${questionIndex}][question]" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Opsi A</label>
                            <input type="text" name="questions[${questionIndex}][option_a]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Opsi B</label>
                            <input type="text" name="questions[${questionIndex}][option_b]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Opsi C</label>
                            <input type="text" name="questions[${questionIndex}][option_c]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Opsi D</label>
                            <input type="text" name="questions[${questionIndex}][option_d]" class="form-control" required>
                        </div>
                         <div class="col-md-6 mb-2">
                            <label>Opsi E</label>
                            <input type="text" name="questions[${questionIndex}][option_e]" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Jawaban Benar</label>
                            <select name="questions[${questionIndex}][correct_answer]" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                </div>
                `;

            container.insertAdjacentHTML('beforeend', html);
            questionIndex++;
        });
    </script>
@endsection
