@extends('layouts.master')
@section('title', 'Materi')
@section('subtitle', 'Daftar')

@section('dashboard', 'collapsed')
@section('materi', '')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

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
                <a href="{{ route('admin.materi.create') }}" class="btn btn-sm btn-success my-3">
                    <i class="bi bi-plus"></i> Tambah
                </a>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Durasi</th>
                            <th>Konten</th>
                            <th>File</th>
                            <th><i class="bi bi-gear"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kontenModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i> Lihat Konten
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="kontenModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="kontenModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kontenModalLabel{{ $item->id }}">Konten
                                                        Materi: {{ $item->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! $item->konten !!}
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

                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#pdfModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i> Lihat pdf
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="pdfModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="pdfModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pdfModalLabel{{ $item->id }}">Konten
                                                        Materi: {{ $item->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src="{{ asset('storage/' . $item->link_pdf) }}" width="100%"
                                                        height="500px" style="border: none;"></iframe>
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
                                    <a href="{{ route('admin.materi.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.materi.destroy', $item->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus?')">
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
