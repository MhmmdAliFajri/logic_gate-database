@extends('layouts.master')
@section('title', 'Materi')
@section('subtitle', 'Tambah')

@section('dashboard', 'collapsed')
@section('materi', '')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Materi</h5>

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

                <form action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data"
                    class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Durasi</label>
                        <input type="number" name="duration" class="form-control" value="{{ old('duration') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="konten" class="form-label">Konten</label>
                        <!-- Quill Editor Default -->
                        <textarea class="tinymce-editor" name="konten" id="konten" rows="10" required>
                            {{ old('konten') }}
                        </textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="link_pdf" class="form-label">Upload PDF</label>
                        <input type="file" name="link_pdf" class="form-control" accept="application/pdf">
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.materi.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
