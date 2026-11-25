<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
<head>
    <meta charset="utf-8">
    <title>Iniciar sesión | Joselito Sport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="{{ asset('velzon/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('velzon/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('velzon/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        .auth-one-bg { background-image: url('{{ asset('velzon/assets/images/Bumper.png') }}'); background-position: center 42%; }
        .auth-one-bg .bg-overlay { background: rgba(20, 0, 0, .35); }
        .btn-login { background-color: #f16b6b; border-color: #f16b6b; color: #fff; }
        .btn-login:hover, .btn-login:focus { background-color: #e85151; border-color: #e85151; color: #fff; }
    </style>
</head>
<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120"><path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path></svg></div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row"><div class="col-lg-12"><div class="text-center mt-sm-5 mb-4 text-white-50">
                    <span class="d-inline-block auth-logo fs-2 fw-bold text-white">Joselito Sport</span>
                    <p class="mt-3 fs-15 fw-medium">Administración de Joselito Sport</p>
                </div></div></div>
                <div class="row justify-content-center"><div class="col-md-8 col-lg-6 col-xl-5"><div class="card mt-4"><div class="card-body p-4">
                    <div class="text-center mt-2"><h5 class="text-primary">Bienvenido</h5><p class="text-muted">Inicia sesión para continuar.</p></div>
                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                            @endif
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingresa tu correo" autocomplete="username" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password-input" class="form-label">Contraseña</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5" id="password-input" name="password" placeholder="Ingresa tu contraseña" autocomplete="current-password" required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon" aria-label="Mostrar contraseña"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" name="remember" value="1" id="auth-remember-check"><label class="form-check-label" for="auth-remember-check">Recordarme</label></div>
                            <div class="mt-4"><button class="btn btn-login w-100" type="submit">Iniciar sesión</button></div>
                        </form>
                    </div>
                </div></div></div></div>
            </div>
        </div>
        <footer class="footer"><div class="container text-center"><p class="mb-0 text-muted">&copy; {{ date('Y') }} Joselito Sport</p></div></footer>
    </div>
    <script src="{{ asset('velzon/assets/libs/particles.js/particles.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/pages/particles.app.js') }}"></script>
    <script src="{{ asset('velzon/assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>
