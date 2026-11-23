<!DOCTYPE html>
<html lang="es" class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de gestión farmacéutica DISFARMA" />
        <meta name="author" content="DISFARMA" />
        <title>@yield('title', 'Dashboard') | DISFARMA</title>

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Font Awesome-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Core theme CSS (Modern Business, incluye Bootstrap)-->
        <link href="{{ asset('sb-admin/css/styles.css') }}" rel="stylesheet" />
    </head>

    <body class="d-flex flex-column h-100">

        <main class="flex-shrink-0">

            <!-- Navigation: barra superior-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid px-4">
                    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                        <i class="fas fa-capsules me-2"></i>DISFARMA
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownUsuario" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i>
                                    {{ auth()->user()->name ?? 'Usuario' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUsuario">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row">

                    <!-- Menú lateral-->
                    <aside class="col-md-3 col-lg-2 bg-dark p-0">

                        <!-- Logo corporativo-->
                        <div class="text-center py-4 border-bottom border-secondary">
                            <i class="fas fa-capsules fa-2x text-white"></i>
                            <div class="text-white fw-bold mt-1">DISFARMA</div>
                        </div>

                        <div class="py-3">
                            <div class="text-white-50 small px-3 mb-2">MENÚ PRINCIPAL</div>
                            <a class="nav-link px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-secondary text-white fw-bold' : 'text-white-50' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home fa-fw me-2"></i> Dashboard
                            </a>

                            <div class="text-white-50 small px-3 mt-4 mb-2">GESTIÓN</div>
                            <a class="nav-link px-4 py-3 {{ request()->is('medicamentos*') ? 'bg-secondary text-white fw-bold' : 'text-white-50' }}" href="{{ url('/medicamentos') }}">
                                <i class="fas fa-pills fa-fw me-2"></i> Medicamentos
                            </a>
                            <a class="nav-link px-4 py-3 {{ request()->is('proveedores*') ? 'bg-secondary text-white fw-bold' : 'text-white-50' }}" href="{{ url('/proveedores') }}">
                                <i class="fas fa-truck fa-fw me-2"></i> Proveedores
                            </a>

                            <div class="text-white-50 small px-3 mt-4 mb-2">PERSONAL</div>
                            <a class="nav-link px-4 py-3 {{ request()->is('empleados*') ? 'bg-secondary text-white fw-bold' : 'text-white-50' }}" href="{{ url('/empleados') }}">
                                <i class="fas fa-users fa-fw me-2"></i> Empleados
                            </a>
                        </div>

                        <div class="text-white-50 small px-3 pb-4 mt-4">
                            Conectado como:
                            <div class="text-white mt-1">{{ auth()->user()->name ?? 'Usuario' }}</div>
                        </div>
                    </aside>

                    <!-- Contenido principal-->
                    <section class="col-md-9 col-lg-10 py-4 px-4 bg-light">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- CONTENEDOR DE INYECCIÓN --}}
                        @hasSection('contenido')
                            @yield('contenido')
                        @else
                            <h2 class="fw-bolder mb-2">Dashboard</h2>
                            <p class="text-muted">Bienvenido al sistema de gestión farmacéutica DISFARMA.</p>
                            <hr>

                            <div class="row gx-5 row-cols-1 row-cols-md-3 mt-4">
                                <div class="col mb-5">
                                    <div class="card h-100 shadow border-0">
                                        <div class="card-body p-4 text-center">
                                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 mx-auto"><i class="bi bi-capsule"></i></div>
                                            <h2 class="h5">Medicamentos</h2>
                                            <p class="mb-3">Administración y control del inventario de medicamentos.</p>
                                            <a href="{{ url('/medicamentos') }}" class="btn btn-primary">Ingresar</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col mb-5">
                                    <div class="card h-100 shadow border-0">
                                        <div class="card-body p-4 text-center">
                                            <div class="feature bg-success bg-gradient text-white rounded-3 mb-3 mx-auto"><i class="bi bi-truck"></i></div>
                                            <h2 class="h5">Proveedores</h2>
                                            <p class="mb-3">Gestión de proveedores de la farmacia.</p>
                                            <a href="{{ url('/proveedores') }}" class="btn btn-success">Ingresar</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col mb-5">
                                    <div class="card h-100 shadow border-0">
                                        <div class="card-body p-4 text-center">
                                            <div class="feature bg-warning bg-gradient text-white rounded-3 mb-3 mx-auto"><i class="bi bi-people"></i></div>
                                            <h2 class="h5">Empleados</h2>
                                            <p class="mb-3">Administración y control del personal.</p>
                                            <a href="{{ url('/empleados') }}" class="btn btn-warning">Ingresar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </section>
                </div>
            </div>
        </main>

        <!-- Footer: pie de página institucional-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container-fluid px-4">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; DISFARMA {{ date('Y') }}. Sistema de Gestión Farmacéutica.</div></div>
                    <div class="col-auto"><div class="small m-0 text-white">Todos los derechos reservados.</div></div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('sb-admin/js/scripts.js') }}"></script>
    </body>
</html>