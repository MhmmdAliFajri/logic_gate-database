@extends('layouts.master')
@section('title', 'Kuis')
@section('subtitle', 'Edit')

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
                <h5 class="card-title">Edit Kuis</h5>

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

                <form action="{{ route('admin.quiz.update', $quiz->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="title" class="form-label">Judul Kuis</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $quiz->title) }}"
                            required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Daftar Pertanyaan</label>
                        <div id="questions-container">
                            @foreach ($quiz->questions as $index => $q)
                                <div class="question-item border p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>#{{ $index + 1 }}</strong>
                                        <button type="button" class="btn btn-sm btn-danger remove-question">Hapus</button>
                                    </div>
                                    <div class="mb-2">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="questions[{{ $index }}][question]"
                                            class="form-control"
                                            value="{{ old("questions.$index.question", $q->question) }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label>Opsi A</label>
                                            <input type="text" name="questions[{{ $index }}][option_a]"
                                                class="form-control"
                                                value="{{ old("questions.$index.option_a", $q->option_a) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Opsi B</label>
                                            <input type="text" name="questions[{{ $index }}][option_b]"
                                                class="form-control"
                                                value="{{ old("questions.$index.option_b", $q->option_b) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Opsi C</label>
                                            <input type="text" name="questions[{{ $index }}][option_c]"
                                                class="form-control"
                                                value="{{ old("questions.$index.option_c", $q->option_c) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Opsi D</label>
                                            <input type="text" name="questions[{{ $index }}][option_d]"
                                                class="form-control"
                                                value="{{ old("questions.$index.option_d", $q->option_d) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Opsi E</label>
                                            <input type="text" name="questions[{{ $index }}][option_e]"
                                                class="form-control"
                                                value="{{ old("questions.$index.option_e", $q->option_e) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jawaban Benar</label>
                                            <select name="questions[{{ $index }}][correct_answer]"
                                                class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="A" {{ $q->correct_answer == 'A' ? 'selected' : '' }}>A
                                                </option>
                                                <option value="B" {{ $q->correct_answer == 'B' ? 'selected' : '' }}>B
                                                </option>
                                                <option value="C" {{ $q->correct_answer == 'C' ? 'selected' : '' }}>C
                                                </option>
                                                <option value="D" {{ $q->correct_answer == 'D' ? 'selected' : '' }}>D
                                                </option>
                                                <option value="E" {{ $q->correct_answer == 'E' ? 'selected' : '' }}>E
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <button type="button" id="add-question" class="btn btn-sm btn-secondary">
                            + Tambah Pertanyaan
                        </button>
                    </div>

                    <div class="text-start mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.quiz.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let questionIndex = {{ count($quiz->questions) }};

        document.getElementById('add-question').addEventListener('click', function() {
            let container = document.getElementById('questions-container');

            let html = `
    <div class="question-item border p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>#${questionIndex + 1}</strong>
            <button type="button" class="btn btn-sm btn-danger remove-question">Hapus</button>
        </div>
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
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('.question-item').remove();
            }
        });
    </script>
@endsection
