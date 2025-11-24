@extends('layouts.master')
@section('title', 'User')
@section('subtitle', 'Daftar')

@section('dashboard', 'collapsed')
@section('materi', 'collapsed')
@section('jobsheet', 'collapsed')
@section('user', '')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
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
                <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-success my-3">
                    <i class="bi bi-plus"></i> Tambah
                </a>
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Foto Profil</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th><i class="bi bi-gear"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    @if ($item->photo != null)
                                        <img src="{{ asset('storage/' . $item->photo) }}" class="img-fluid" width="64"
                                            alt="" srcset="">
                                    @else
                                        <img src="{{ asset('img/person-404.png') }}" class="img-fluid" width="64"
                                            alt="">
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <form method="POST" id="form-reset-password"
                                        action="{{ route('admin.user.update', $item->id) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-sm btn-warning btn-reset-password"
                                            data-id="{{ $item->id }}">
                                            Reset Password
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.user.destroy', $item->id) }}"
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
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetPasswordButtons = document.querySelectorAll('.btn-reset-password');

            resetPasswordButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const form = button.closest('form');


                    Swal.fire({
                        title: 'Apakah anda yakin mereset password ini?',
                        text: "Data akan memiliki password default 'password'!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, reset!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
