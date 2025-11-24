@extends('layouts.master')
@section('title', 'Kuis')
@section('subtitle', 'Daftar')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('quiz', '')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')

@section('content')
    <div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body pt-4">
                <a href="{{ route('admin.quiz.create') }}" class="btn btn-sm btn-success my-3">
                    <i class="bi bi-plus"></i> Tambah Kuis
                </a>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jumlah Pertanyaan</th>
                            <th>Lihat Pertanyaan</th>
                            <th><i class="bi bi-gear"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->questions_count }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#questionModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i> Lihat Pertanyaan
                                    </button>

                                    <!-- Modal Pertanyaan -->
                                    <div class="modal fade" id="questionModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="questionModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="questionModalLabel{{ $item->id }}">
                                                        Pertanyaan Quiz: {{ $item->title }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach ($item->questions as $q)
                                                        <div class="mb-3">
                                                            <strong>{{ $loop->iteration }}. {{ $q->question }}</strong>
                                                            <ul class="mb-0">
                                                                <li>A. {{ $q->option_a }}</li>
                                                                <li>B. {{ $q->option_b }}</li>
                                                                <li>C. {{ $q->option_c }}</li>
                                                                <li>D. {{ $q->option_d }}</li>
                                                                <li>E. {{ $q->option_e }}</li>
                                                            </ul>
                                                            <small class="text-success">Jawaban benar:
                                                                {{ $q->correct_answer }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.quiz.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.quiz.destroy', $item->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus quiz ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
