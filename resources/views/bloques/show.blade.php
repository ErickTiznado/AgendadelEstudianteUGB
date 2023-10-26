@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detalles del Bloque</div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>Tipo:</strong> {{ $bloque->tipo }}
                    </div>
                    <div class="mb-3">
                        <strong>Inicio:</strong> {{ $bloque->inicio }}
                    </div>
                    <div class="mb-3">
                        <strong>Fin:</strong> {{ $bloque->fin }}
                    </div>
                    <div class="mb-3">
                        <strong>Día de la semana:</strong> {{ $bloque->dia_semana }}
                    </div>
                    <div class="mb-3">
                        <strong>Notas:</strong> {{ $bloque->notas ?? 'N/A' }}
                    </div>
                    <a href="{{ route('bloques.edit', $bloque->id) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('bloques.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
