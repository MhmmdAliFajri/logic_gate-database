@extends('layouts.master')
@section('title', 'Materi')
@section('subtitle', 'Edit')

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
                <h5 class="card-title">Edit Materi</h5>

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

                <form action="{{ route('admin.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data"
                    class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $materi->title) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Durasi</label>
                        <input type="text" name="duration" class="form-control"
                            value="{{ old('duration', $materi->duration) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="konten" class="form-label">Konten</label>
                        <!-- Quill Editor Default -->
                        <textarea class="tinymce-editor" name="konten" id="konten" rows="10" required>
                            {{ old('konten', $materi->konten) }}
                        </textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="link_pdf" class="form-label">Upload PDF Baru (opsional)</label>
                        <input type="file" name="link_pdf" class="form-control" accept="application/pdf">
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $materi->link_pdf) }}"
                                target="_blank">Lihat PDF</a></small>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.materi.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@section('scripts')
    <script>
        var quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        // Isi konten awal dari input hidden
        var kontenAwal = document.getElementById('konten_data').value;
        if (kontenAwal) {
            quill.root.innerHTML = kontenAwal;
        }

        // Sync isi konten ke input hidden sebelum submit
        const form = document.querySelector('form');
        form.onsubmit = function() {
            document.getElementById('konten_input').value = quill.root.innerHTML;
        };
    </script>
@endsection

@endsection
