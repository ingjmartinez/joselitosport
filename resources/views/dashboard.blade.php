<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
<head>
    <meta charset="utf-8">
    <title>Panel | Joselito Sport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="{{ asset('velzon/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('velzon/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('velzon/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --vz-vertical-menu-bg-dark: #172235;
            --vz-vertical-menu-item-color-dark: #b9c6d8;
            --vz-vertical-menu-item-hover-color-dark: #fff;
            --vz-vertical-menu-item-active-color-dark: #fff;
        }
        .navbar-brand-box .brand-name { color: #fff; font-size: 1.25rem; font-weight: 700; letter-spacing: .02em; white-space: nowrap; }
        .navbar-brand-box .brand-name strong { color: #ffca62; }
        .navbar-menu .menu-title span { color: #ffca62; }
        .navbar-menu .nav-link.active { background: rgba(255, 202, 98, .13); border-left: 3px solid #ffca62; }
        .navbar-menu .nav-link.active i { color: #ffca62; }
        .dashboard-banner { background: linear-gradient(90deg, rgba(23, 34, 53, .96), rgba(23, 34, 53, .48)), url('{{ asset('velzon/assets/images/Bumper.png') }}') center 45% / cover; border-radius: 1rem; color: #fff; }
        .dashboard-banner .eyebrow { color: #ffca62; letter-spacing: .12em; text-transform: uppercase; }
        .sidebar-backdrop { display: none; }
        @media (max-width: 991.98px) {
            .sidebar-backdrop { position: fixed; inset: 0; z-index: 1001; background: rgba(12, 20, 33, .55); }
            .vertical-sidebar-enable .sidebar-backdrop { display: block; }
        }
    </style>
</head>
<body>
    <div id="layout-wrapper">
        <header id="page-topbar"><div class="layout-width"><div class="navbar-header">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger d-lg-none" id="sidebar-toggle" aria-label="Abrir o cerrar menú" aria-controls="sidebar-menu" aria-expanded="false">
                    <span class="hamburger-icon"><span></span><span></span><span></span></span>
                </button>
                <span class="fw-semibold">Joselito Sport</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Cerrar sesión">
                        <i class="ri-logout-box-r-line me-1" aria-hidden="true"></i>Cerrar sesión
                    </button>
                </form>
            </div>
        </div></div></header>

        <aside class="app-menu navbar-menu" id="sidebar-menu" aria-label="Menú principal">
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-light" aria-label="Joselito Sport, panel principal">
                    <span class="brand-name">Joselito <strong>Sport</strong></span>
                </a>
            </div>
            <div id="scrollbar"><div class="container-fluid">
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menú</span></li>
                    <li class="nav-item"><a class="nav-link menu-link active" href="{{ route('dashboard') }}" aria-current="page"><i class="ri-dashboard-2-line"></i><span>Panel</span></a></li>
                </ul>
            </div></div>
            <div class="sidebar-background"></div>
        </aside>
        <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

        <div class="main-content">
            <div class="page-content"><div class="container-fluid">
                <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h1 class="mb-sm-0 fs-16 fw-semibold">Panel</h1></div></div></div>
                <div class="dashboard-banner p-4 p-md-5">
                    <p class="eyebrow fw-semibold mb-2">Joselito Sport</p>
                    <h2 class="text-white mb-2">Bienvenido, {{ auth()->user()->name }}.</h2>
                    <p class="text-white-50 mb-0">Tu espacio de administración está listo.</p>
                </div>
            </div></div>
            <footer class="footer"><div class="container-fluid">&copy; {{ date('Y') }} Joselito Sport</div></footer>
        </div>
    </div>
    <script>
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');
        function toggleSidebar() {
            const isOpen = document.body.classList.toggle('vertical-sidebar-enable');
            sidebarToggle.setAttribute('aria-expanded', String(isOpen));
        }
        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarBackdrop.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
