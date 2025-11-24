@extends('layouts.master')
@section('title', 'Log Jobsheet')
@section('subtitle', 'Daftar')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', '')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

@section('content')
    <div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body pt-4">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Jobsheet</th>
                            <th>PDF</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th><i class="bi bi-gear"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->jobsheet->title ?? '-' }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $item->link_pdf) }}" target="_blank"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-pdf"></i> View
                                    </a>
                                </td>
                                <td>{{ $item->nilai ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $item->status == 'graded' ? 'success' : ($item->status == 'submitted' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.log-jobsheet.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.log-jobsheet.destroy', $item->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $item->id }}">
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
