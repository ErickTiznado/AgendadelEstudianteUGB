@extends('layouts.appweb') <!-- Asumiendo que tienes un layout base -->

@section('content')

<style>
    body {
        background-color: #3217ea;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
        padding: 20px;
    }
    .container {
        background-color: rgba(255,255,255,0.1); /* Agregar un fondo ligeramente transparente al contenedor */
        padding: 20px;
        border-radius: 15px; /* Bordes redondeados en el contenedor */
    }
    .form-control {
        background-color: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
        color: #ffffff;
        margin-bottom: 10px; /* Espacio debajo de cada input */
    }
    .form-control:focus {
        border-color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
    }
    button[type="submit"], .btn {
        width: 100%;
        font-weight: bold;
        transition: background-color 0.3s, color 0.3s;
        margin-bottom: 10px; /* Espacio entre botones */
        border-radius: 10px; /* Bordes redondeados en botones */
    }
    .btn:hover {
        background-color: #0c0667;
        color: #ffffff;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px; /* Espacio entre filas de la tabla */
    }
    table th, table td {
        padding: 10px;
        background-color: rgba(255,255,255,0.05); /* Fondo ligeramente transparente para celdas */
        border: none;
    }
    table th {
        text-align: left;
    }
    table tr:nth-child(even) td {
        background-color: rgba(255,255,255,0.08); /* Un color ligeramente diferente para filas alternas */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('materias.create') }}" class="btn btn-primary">Agregar Materia</a>
        </div>
    </div>
    <br>
    @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materias as $materia)
                    <tr>
                        <td>{{ $materia->nombre }}</td>
                        <td>
                        <a href="{{ route('materias.edit', $materia->materia_id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('materias.destroy', $materia->materia_id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta materia?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
</form>
                            <!-- Aquí puedes agregar un botón para eliminar, pero es recomendable usar un modal de confirmación -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
