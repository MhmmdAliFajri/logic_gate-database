@extends('layouts.master')
@section('title', 'Log Jobsheet')
@section('subtitle', 'Edit')

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
                <h5 class="card-title">Pemberian Nilai Jobsheet</h5>
                <dl class="row">
                    <dt class="col-sm-3 col-md-2">Nama</dt>
                    <dd class="col-sm-9 col-md-10">{{ $logJobsheet->user->name }}</dd>

                    <dt class="col-sm-3 col-md-2">Jobsheet</dt>
                    <dd class="col-sm-9 col-md-10">{{ $logJobsheet->jobsheet->title }}</dd>
                </dl>


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

                <form action="{{ route('admin.log-jobsheet.update', $logJobsheet->id) }}" method="POST"
                    enctype="multipart/form-data" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="link_pdf" class="form-label">File Yang dikumpulkan</label>
                        <iframe src="{{ asset('storage/' . $logJobsheet->link_pdf) }}" width="100%" height="500px"
                            style="border: none;"></iframe>
                    </div>

                    <div class="col-md-3">
                        <label for="nilai" class="form-label">Nilai</label>

                        <input type="number" name="nilai" id="nilai" class="form-control"
                            value="{{ old('nilai') ?? $logJobsheet->nilai }}">
                        <small> 1 - 100</small>
                    </div>

                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.log-jobsheet.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
