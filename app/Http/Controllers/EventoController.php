<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Obtener todos los bloques para el calendario
    public function index()
    {
        
        $bloques = Bloque::where('usuario_id', auth()->id())
        
            ->get()
            ->map(function ($bloque) {
                $fechaActual = date('Y-m-d'); // Puedes ajustar esto según tus necesidades
                return [
                    'id' => $bloque->id,
                    'title' => $bloque->tipo,
                    'start' => $fechaActual . 'T' . $bloque->inicio,
                    'end' => $fechaActual . 'T' . $bloque->fin,
                    // Puedes agregar más campos si es necesario
                ];
            });
        return response()->json($bloques);
    }

    // Mostrar el formulario para crear un nuevo bloque
    public function create()
    {
        return view('bloques.create');
    }

    public function showCalendar()
{
    return view('calendar');
}
    // Guardar el bloque en la base de datos
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|string',
            'inicio' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:inicio',
            'dia_semana' => 'required|string',
            'notas' => 'nullable|string',
        ]);

        $data['usuario_id'] = auth()->id();

        Bloque::create($data);

        return redirect()->route('bloques.index')->with('success', 'Bloque creado con éxito.');
    }
}
