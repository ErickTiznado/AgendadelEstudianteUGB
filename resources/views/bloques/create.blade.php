@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar Bloque</h2>
    <form action="{{ route('bloques.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="inicio">Inicio</label>
            <input type="time" name="inicio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fin">Fin</label>
            <input type="time" name="fin" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="dia_semana">Día de la semana</label>
            <input type="text" name="dia_semana" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="notas">Notas</label>
            <textarea name="notas" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
