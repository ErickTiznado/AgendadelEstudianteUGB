<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Muestra una lista de todas las materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    /**
     * Muestra el formulario para crear una nueva materia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materias.create');
    }

    /**
     * Almacena una nueva materia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:materias,nombre'
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una materia existente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }

    /**
     * Actualiza una materia existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:materias,nombre,' . $id
        ]);

        $materia = Materia::findOrFail($id);
        $materia->update($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');
    }

    /**
     * Elimina una materia.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();
        
        return redirect()->route('materias.index')->with('success', 'Materia eliminada con éxito');
    }
}
