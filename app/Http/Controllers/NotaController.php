<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Materia;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    // Mostrar todas las notas
    public function index(Request $request)
    {
        $materias = Materia::all();

        if ($request->has('materia') && $request->materia != '') {
            $notas = Nota::where('materia', $request->materia)->get();
        } else {
            $notas = Nota::all();
        }
        return view('notas.index', [
            'notas' => $notas,
            'materias' => $materias
        ]);
    }

    // Mostrar el formulario para crear una nota
    public function create()
    {
        $materias = Materia::all();
        return view('notas.create', compact('materias'));
    }

    // Guardar una nota
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'materia' => 'required',
            'fecha' => 'required|date'
        ]);
        $data['usuario_id'] = auth()->user()->id;
        

        Nota::create($data);
        return redirect()->route('notas.index')->with('success', 'Nota creada con éxito.');
    }

    // Mostrar el formulario para editar una nota
    public function edit(Nota $nota)
    {
        $materias = Materia::all();
        return view('notas.edit', compact('nota', 'materias'));
    }

    // Actualizar una nota
    public function update(Request $request, Nota $nota)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required',
            'materia' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        $data['materia_id'] = $data['materia'];
        unset($data['materia']);
        
        $nota->update($data);

        return redirect()->route('notas.index')->with('success', 'Nota actualizada con éxito.');
    }

    // Eliminar una nota
    public function destroy(Nota $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('success', 'Nota eliminada con éxito.');
    }
}
