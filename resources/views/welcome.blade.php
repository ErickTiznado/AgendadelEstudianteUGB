<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi App</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img style="width: 120px; height: 52px; margin-right: 10px;" src="{{ asset('img\Logotipo-horizontal-blanco.png') }}" alt="Asistente virtual" class="img-fluid" />
                Agenda del Estudiante UGB
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h1 class="mb-5">Bienvenido a la Agenda del Estudiante</h1> <!-- Cambiado el margen inferior -->
        <p class="lead mb-5">¡Bienvenido a nuestra aplicación web de agenda!

            Estamos encantados de que hayas elegido nuestra plataforma para organizar tu vida. Nuestra aplicación está diseñada para ayudarte a mantener un registro claro y ordenado de tus citas, tareas y eventos importantes.
            
            Con una interfaz fácil de usar y una amplia gama de características, estamos seguros de que encontrarás nuestra aplicación indispensable para tu día a día. Ya sea que necesites recordatorios para tus reuniones de trabajo, fechas límite para tus proyectos o simplemente un lugar donde anotar tus pensamientos e ideas, nuestra aplicación de agenda tiene todo lo que necesitas.
            
            ¡Empecemos a organizar tu tiempo de la mejor manera posible! ¡Disfruta de la experiencia!</p>
        <a href="{{ route('register') }}" class="btn btn-light mr-3">Registro</a> <!-- Añadido botón de Registro con estilo -->
        <a href="{{ route('login') }}" class="btn btn-light">Login</a> <!-- Añadido botón de Login con estilo -->
    </div>
    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
