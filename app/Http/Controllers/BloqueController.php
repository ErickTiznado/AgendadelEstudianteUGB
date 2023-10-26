<?php

namespace App\Http\Controllers;
use App\Models\Bloque;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BloqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar un bloque específico
public function show(Bloque $bloque)
{
    return view('bloques.show', compact('bloque'));
}


    // Listar todos los bloques del usuario
    public function index()
    {
        $bloques = auth()->user()->bloques;
        return view('bloques.index', compact('bloques'));
    }

    // Mostrar el formulario para crear un nuevo bloque
    public function create()
    {
        return view('bloques.create');
    }

    // Guardar el bloque en la base de datos
    public function store(Request $request)
    {
        $data = $request->all();
        $data['usuario_id'] = auth()->id();
    
        // Validar que no haya superposición con otros bloques
        $bloquesSuperpuestos = Bloque::where('usuario_id', auth()->id())
            ->where('inicio', '<', $data['fin'])
            ->where('fin', '>', $data['inicio'])
            ->count();
    
        if ($bloquesSuperpuestos > 0) {
            return response()->json(['error' => 'El bloque se superpone con otro bloque existente.'], 400);
        }
    
        // Si el bloque es de tipo "Sueño", validar que sea único
        if ($data['tipo'] === 'Sueño') {
            $bloquesSueno = Bloque::where('usuario_id', auth()->id())
                ->where('tipo', 'Sueño')
                ->count();
    
            if ($bloquesSueno > 0) {
                return response()->json(['error' => 'Ya existe un bloque de sueño para este usuario.'], 400);
            }
        }
    
        // Si el tipo es 'Clase', se repite a lo largo de la semana
        if ($data['tipo'] === 'Clase') {
            $data['repetir'] = true;
        }
    
        // Si el tipo es 'Otros' y la clave 'otros_tipo' existe en la solicitud
        if ($data['tipo'] === 'Otros' && isset($data['otros_tipo']) && in_array($data['otros_tipo'], ['Desayuno', 'Almuerzo', 'Cena', 'Sueño'])) {
            $data['repetir'] = true;
        }
    
        $bloque = Bloque::create($data);
    
        return view("calendar");
    }


    // Mostrar el formulario para editar un bloque existente
    public function edit(Bloque $bloque)
    {
        return view('bloques.edit', compact('bloque'));
    }

    // Actualizar el bloque en la base de datos
// Actualizar el bloque en la base de datos
public function update(Request $request, Bloque $bloque)
{
    // 1. Recoger todos los datos del request.
    $data = $request->all();
    // 3. Validar que el bloque que estás intentando actualizar no se superponga con otros bloques existentes.
    $bloquesSuperpuestos = Bloque::where('usuario_id', auth()->id())
        ->where('id', '!=', $bloque->id) // Excluir el bloque actual
        ->where('inicio', '<', $data['fin'])
        ->where('fin', '>', $data['inicio'])
        ->count();

    if ($bloquesSuperpuestos > 0) {
        return response()->json(['error' => 'El bloque se superpone con otro bloque existente.'], 400);
    }

    // 4. Actualizar el bloque en la base de datos.
    $bloque->update($data);

    return view("calendar");
}

    
    
    

    // Eliminar un bloque
    public function destroy(Bloque $bloque)
    {
        $bloque->delete();
        return view('calendar');
    }

    public function getBloques() {
        $bloques = auth()->user()->bloques;
        
        $formattedBloques = [];
    
        foreach ($bloques as $bloque) {
            $baseData = [
                'id' => $bloque->id,
                'calendarId' => '1',
                'start' => $bloque->inicio,
                'end' => $bloque->fin,
                'category' => 'time',
                'bgColor' => $bloque->color,
            ];
            // Formatear el título según el tipo de bloque
            if ($bloque->tipo === 'Clase') {
                $baseData['title'] = $bloque->TItulo . "\n" . 
                                     Carbon::parse($bloque->inicio)->format('H:i') . " - " . 
                                     Carbon::parse($bloque->fin)->format('H:i');
            } else {
                $baseData['title'] = $bloque->TItulo . "\n" . 
                                     Carbon::parse($bloque->inicio)->format('H:i') . " - " . 
                                     Carbon::parse($bloque->fin)->format('H:i');
            }
    
            $baseData['body'] = [
                'notas' => $bloque->nota
            ];
    
            $formattedBloques[] = $baseData;
    
            // Si el bloque es de tipo "Sueño" o "Comida", generamos bloques repetidos
            if (in_array($bloque->tipo, ['Sueño', 'Comida'])) {
                for ($i = -365; $i <= 365; $i++){  
                    // Excluir el día actual para evitar duplicación
                    if ($i == 0) {
                        continue;
                    }
                    
                    $newBlock = $baseData;
                    $newBlock['start'] = Carbon::parse($bloque->inicio)->addDays($i);
                    $newBlock['end'] = Carbon::parse($bloque->fin)->addDays($i);
                    $formattedBloques[] = $newBlock;
                }
            }
        }
    
        return response()->json($formattedBloques);
    }
    
}
