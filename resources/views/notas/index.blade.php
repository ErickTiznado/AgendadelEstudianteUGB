@extends('layouts.appweb')

@section('content')

<!-- Estilos para las notas -->
<style>
    body {
        background-color: #3217ea;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
    }

    .sticky-note {
        background-color: rgba(25, 12, 146, 0.9); /* Color amarillo */
        position: relative;
        transform: rotate(-1deg); /* Ligera rotación */
        transition: transform 0.3s ease;
        border: none;
        border-radius: 5px;
        box-shadow: 0px 0px 40px rgba(0,0,0,0.3);
    }

    .sticky-note:hover {
        transform: scale(1.05) rotate(0deg); /* Aumenta un poco el tamaño y corrige la rotación al pasar el ratón */
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

    .edit-btn, .delete-btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    
</style>

<div class="container">

    <!-- Filtro por materia -->
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('notas.index') }}" method="GET" class="form-inline">
                <label for="materia" class="mr-2">Filtrar por materia:</label>
                <select name="materia" id="materia" class="form-control" onchange="this.form.submit()">
                    <option value="">Todas las materias</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->materia_id }}" {{ request('materia') == $materia->materia_id ? 'selected' : '' }}>{{ $materia->nombre }}</option>
                    @endforeach
                </select>
                <a href="{{ route('notas.create') }}" class="btn btn-primary ml-auto">Agregar Nota</a>
            </form>
        </div>
    </div>

    <!-- Notas como sticky notes -->
    <div class="row mt-3">
        @foreach($notas as $nota)
        <div class="col-md-3 mb-3">
            <div class="card sticky-note">
                <div class="card-body">
                    <h5 class="card-title">{{ $nota->titulo }}</h5>
                    <p class="card-text">{{ $nota->contenido }}</p>
                    <span class="badge badge-primary">{{ $nota->materiaRelacion->nombre }}</span>
                    <div class="mt-2">
                        <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-sm btn-warning edit-btn">Editar</a>
                        <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger delete-btn">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
