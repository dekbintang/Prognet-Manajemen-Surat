<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SURATKU') }}</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root { --sidebar-open: 280px; --sidebar-close: 86px; }
        body { background: #f4f7fb; }

        .sidebar {
            position: fixed; inset: 0 auto 0 0;
            width: var(--sidebar-open);
            min-height: 100vh;
            background: linear-gradient(180deg, #0b1424 0%, #070c16 100%);
            color: #fff;
            transition: width .2s ease;
            z-index: 1030;
            overflow-x: hidden;
        }
        body.sidebar-collapsed .sidebar { width: var(--sidebar-close); }

        .brand {
            height: 64px;
            background: rgba(0,0,0,.25);
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding: 0 16px;
            display:flex; align-items:center; justify-content:space-between;
        }
        .brand .brand-title { font-weight: 800; letter-spacing:.3px; }

        .nav-section {
            padding: 10px 16px 6px;
            color: rgba(226,232,240,.55);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .8px;
        }
        body.sidebar-collapsed .nav-section { display:none; }

        .sidebar .nav-link {
            color: rgba(226,232,240,.92);
            border-radius: 14px;
            padding: 12px 14px;
            display:flex; align-items:center; gap: 12px;
            transition: .15s ease;
            margin: 0 12px;
        }
        .sidebar .nav-link i { width: 22px; text-align:center; }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.08); color:#fff; }
        .sidebar .nav-link.active {
            background: rgba(14,165,233,.18);
            border: 1px solid rgba(14,165,233,.25);
            color:#fff;
        }
        .nav-text { white-space: nowrap; }
        body.sidebar-collapsed .nav-text { display:none; }

        .main-wrap {
            margin-left: var(--sidebar-open);
            transition: margin-left .2s ease;
            min-height: 100vh;
            display:flex; flex-direction: column;
        }
        body.sidebar-collapsed .main-wrap { margin-left: var(--sidebar-close); }

        .topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e9eef6;
            position: sticky; top: 0;
            z-index: 1020;
        }

        .avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: #0f172a;
            color: #fff;
            display:flex; align-items:center; justify-content:center;
            font-weight: 800;
        }
    </style>
</head>

<body>
@php $user = auth()->user(); @endphp

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="brand">
        <div class="d-flex align-items-center gap-2">
            <span class="fs-5">📧</span>
            <span class="brand-title nav-text">SURATKU</span>
        </div>
        <span></span>
    </div>

    <nav class="pt-3">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="nav-section">Surat</div>

        <a href="{{ route('surat-masuk.index') }}" class="nav-link {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}">
            <i class="fas fa-inbox text-success"></i>
            <span class="nav-text">Surat Masuk</span>
        </a>

        <a href="{{ route('surat-keluar.index') }}" class="nav-link {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}">
            <i class="fas fa-paper-plane text-warning"></i>
            <span class="nav-text">Surat Keluar</span>
        </a>

        <div class="nav-section">Agenda</div>

        <a href="{{ route('agenda.index') }}" class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt text-info"></i>
            <span class="nav-text">Agenda Kegiatan</span>
        </a>

        <div class="nav-section">Master Data</div>

        <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="fas fa-folder text-primary"></i>
            <span class="nav-text">Kategori Surat</span>
        </a>

        <a href="{{ route('jenis-agenda.index') }}" class="nav-link {{ request()->routeIs('jenis-agenda.*') ? 'active' : '' }}">
            <i class="fas fa-tags text-danger"></i>
            <span class="nav-text">Jenis Agenda</span>
        </a>
    </nav>

    <div class="px-3 pb-4 mt-auto">
        <div class="rounded-4 p-3" style="background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.10);">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar" style="background:#0ea5e9;">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="fw-bold text-truncate">{{ $user->name ?? 'User' }}</div>
                    <div class="text-white-50 small text-truncate">{{ $user->email ?? '-' }}</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-link w-100 text-start">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="main-wrap">
    <header class="topbar d-flex align-items-center justify-content-between px-3 px-lg-4">
        <button id="btnToggleSidebar" class="btn btn-light border-0">
            <i class="fas fa-bars"></i>
        </button>

        <div class="d-flex align-items-center gap-3">
            <span class="text-secondary d-none d-md-inline">{{ $user->name ?? 'User' }}</span>

            <div class="dropdown">
                <button class="btn p-0 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <div class="avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul> 
            </div>
        </div>
    </header>

    <main class="p-3 p-lg-4">
        {{-- Flash --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot }}
    </main>
</div>

{{-- Bootstrap JS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Sidebar toggle --}}
<script>
  (function () {
    const key = 'simsurat_sidebar';
    const body = document.body;
    const btn  = document.getElementById('btnToggleSidebar');

    const saved = localStorage.getItem(key);
    if (saved === 'collapsed') body.classList.add('sidebar-collapsed');

    btn?.addEventListener('click', function () {
      body.classList.toggle('sidebar-collapsed');
      localStorage.setItem(key, body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
    });
  })();
</script>

</body>
</html>
