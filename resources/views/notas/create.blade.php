@extends('layouts.appweb')

@section('content')

<style>
    body {
        background-color: #3217ea;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
    }
    .form-control {
        background-color: rgba(255,255,255,0.1); /* Haciendo los inputs un poco transparentes para que se integren con el fondo */
        border-color: rgba(255,255,255,0.3); /* Cambiando el borde a blanco semi-transparente */
        color: #ffffff;
    }
    .form-control:focus {
        border-color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25); /* Modificando el glow al hacer focus */
    }
    button[type="submit"] {
    width: 100%; /* Haciendo que el botón de registro ocupe todo el ancho */
}

.btn {
    font-weight: bold; /* Negrita para los botones */
    transition: background-color 0.3s, color 0.3s; /* Transición suave para cambios de color */
}

.btn:hover {
    background-color: #0c0667;
    color: #ffffff;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3>Agregar Nota</h3>
            <form action="{{ route('notas.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="contenido">Contenido</label>
                    <textarea class="form-control" id="contenido" name="contenido" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="materia_id">Materia</label>
                    <select name="materia" id="materia" class="form-control" required>
    @foreach($materias as $materia)
        <option value="{{ $materia->materia_id }}">{{ $materia->nombre }}</option>
    @endforeach
</select>

                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
