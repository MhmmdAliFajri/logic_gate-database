@extends('layouts.master')
@section('title', 'Jobsheet')
@section('subtitle', 'Edit')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('jobsheet', '')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Jobsheet</h5>

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

                <form action="{{ route('admin.jobsheet.update', $jobsheet->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $jobsheet->title) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Durasi</label>
                        <input type="text" name="duration" class="form-control"
                            value="{{ old('duration', $jobsheet->duration) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $jobsheet->description) }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="link_pdf" class="form-label">Upload PDF Baru (opsional)</label>
                        <input type="file" name="link_pdf" class="form-control" accept="application/pdf">
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $jobsheet->link_pdf) }}"
                                target="_blank">Lihat PDF</a></small>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.jobsheet.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
