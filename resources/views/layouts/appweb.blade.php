<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AgendaUGB</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['public\css\navbar.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Tu Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/home">
            <img style="width: 120px; height: 52px; margin-right: 10px;" src="{{ asset('img\Logotipo-horizontal-blanco.png') }}" alt="Asistente virtual" class="img-fluid" />
            AgendaUGB
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/materias">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/notas">Notas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/asistente">Asistente</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>