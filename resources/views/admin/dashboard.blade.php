@extends('layouts.master')
@section('title', 'Dashboard')
@section('subtitle', 'dashboard')
@section('dashboard', '')
@section('materi', 'collapsed')
@section('jobsheet', 'collapsed')
@section('add', 'collapsed')
@section('log-jobsheet', 'collapsed')
@section('user', 'collapsed')
@section('quiz', 'collapsed')

@section('content')
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Jumlah Siswa Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Siswa</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $items['user'] }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Jumlah Siswa Card -->

                    <!-- Jumlah Materi Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Materi</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $items['materi'] }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Jumlah Materi Card -->
                    <!-- Jumlah Jobsheet Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Jobsheet</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $items['jobsheet'] }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Jumlah Jobsheet Card -->
                    <!-- Jumlah Add Card -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Add</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard-plus"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $items['add'] }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Jumlah Add Card -->
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection
