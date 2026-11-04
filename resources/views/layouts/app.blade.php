<!DOCTYPE html>
<html lang="id">
<head>
    {{-- ==================================================
         BAGIAN 1: META DAN STYLESHEET
         ================================================== --}}

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | Sistem Manajemen Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/pegawai.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    {{-- ==================================================
         BAGIAN 2: KERANGKA HALAMAN
         ================================================== --}}

    <div class="app-shell">

        {{-- ==================================================
             BAGIAN 3: SIDEBAR DAN NAVIGASI
             ================================================== --}}

        <aside class="sidebar">

            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <span class="brand-mark">SM</span>
                <span>Sistem Manajemen Data Pegawai</span>
            </a>

            {{-- KATEGORI MENU --}}
            <div class="px-3 mb-2 mt-2 text-uppercase text-secondary fs-7 fw-bold" style="letter-spacing: 0.05rem; opacity: 0.7;">
                Menu Utama
            </div>

            <nav class="nav flex-column gap-1" aria-label="Menu utama">

                <a href="{{ route('dashboard') }}"
                   class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   @if(request()->routeIs('dashboard')) aria-current="page" @endif
                >
                    <i class="bi bi-grid-1x2-fill me-2 fs-6"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pegawai.index') }}"
                   class="nav-link d-flex align-items-center {{ request()->routeIs('pegawai.*') ? 'active' : '' }}"
                   @if(request()->routeIs('pegawai.*')) aria-current="page" @endif
                >
                    <i class="bi bi-people-fill me-2 fs-6"></i>
                    <span>Data Pegawai</span>
                </a>

            </nav>

           {{-- ==================================================
            BAGIAN 4: IDENTITAS DAN LOGOUT
            ================================================== --}}

            <div class="sidebar-footer">
                <p class="small text-secondary mb-1">
                    Login sebagai
                </p>

                <p class="fw-semibold text-brand-dark mb-3">
                    {{ auth()->user()->username }}
                </p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    {{-- PERUBAHAN CLASS TOMBOL LOGOUT --}}
                    <button type="submit" class="btn btn-logout-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ==================================================
             BAGIAN 5: KONTEN HALAMAN
             ================================================== --}}

        <main class="main-content">
            {{-- TOMBOL TOGGLE SIDEBAR --}}
            <button type="button" id="sidebarToggle" class="btn btn-light border shadow-sm mb-4">
                <i class="bi bi-list fs-5"></i>
            </button>

            @yield('content')
        </main>

    </div>

    {{-- ==================================================
         BAGIAN 6: JAVASCRIPT
         ================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    
        document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.querySelector('.app-shell').classList.toggle('sidebar-collapsed');
        });

    </script>

    @stack('scripts')

</body>
</html>