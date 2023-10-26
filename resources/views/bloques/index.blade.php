@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bloques</h2>
    <a href="{{ route('bloques.create') }}" class="btn btn-primary">Agregar Bloque</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Día de la semana</th>
                <th>Notas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bloques as $bloque)
            <tr>
                <td>{{ $bloque->tipo }}</td>
                <td>{{ $bloque->inicio }}</td>
                <td>{{ $bloque->fin }}</td>
                <td>{{ $bloque->dia_semana }}</td>
                <td>{{ $bloque->notas }}</td>
                <td>
                    <a href="{{ route('bloques.edit', $bloque->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('bloques.destroy', $bloque->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
