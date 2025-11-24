@php
    use App\Models\LogJobsheet;
    $jumlahMenungguNilai = LogJobsheet::where('status', 'submitted')->count();
@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @if (auth()->user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link @yield('dashboard')" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('user')" href="{{ route('admin.user.index') }}">
                    <i class="bi bi-person"></i>
                    <span>User</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('materi')" href="{{ route('admin.materi.index') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Materi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('jobsheet')" href="{{ route('admin.jobsheet.index') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Jobsheet</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('add')" href="{{ route('admin.add.index') }}">
                    <i class="bi bi-clipboard-plus"></i>
                    <span>Add</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('quiz')" href="{{ route('admin.quiz.index') }}">
                    <i class="bi bi-lightbulb"></i>
                    <span>Kuis</span>
                </a>
            </li>

            <p class="mt-4 text-uppercase text-muted small px-3">Pengumpulan</p>

            <li class="nav-item">
                <a class="nav-link @yield('log-jobsheet')" href="{{ route('admin.log-jobsheet.index') }}">
                    <i class="bi bi-person-check"></i>
                    <span>
                        Tugas Siswa
                        @if ($jumlahMenungguNilai > 0)
                            <span class="badge bg-danger ms-2">{{ $jumlahMenungguNilai }}</span>
                        @endif
                    </span>
                </a>
            </li>
        @endif
    </ul>
</aside>
