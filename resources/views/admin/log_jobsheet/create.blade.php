@extends('layouts.master')
@section('title', 'Log Jobsheet')
@section('subtitle', 'Tambah')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', '')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Log Jobsheet</h5>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Periksa kembali!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.log-jobsheet.store') }}" method="POST" enctype="multipart/form-data"
                    class="row g-3">
                    @csrf

                    <div class="col-md-6">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="jobsheet_id" class="form-label">Jobsheet</label>
                        <select name="jobsheet_id" id="jobsheet_id" class="form-select" required>
                            <option value="">-- Pilih Jobsheet --</option>
                            @foreach ($jobsheets as $sheet)
                                <option value="{{ $sheet->id }}"
                                    {{ old('jobsheet_id') == $sheet->id ? 'selected' : '' }}>
                                    {{ $sheet->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="link_pdf" class="form-label">File PDF</label>
                        <input type="file" name="link_pdf" id="link_pdf" class="form-control" required
                            accept="application/pdf">
                    </div>

                    <div class="col-md-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input type="number" name="nilai" id="nilai" class="form-control"
                            value="{{ old('nilai') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Submitted
                            </option>
                            <option value="graded" {{ old('status') == 'graded' ? 'selected' : '' }}>Graded</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.log-jobsheet.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
