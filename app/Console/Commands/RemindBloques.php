<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bloque;
use Carbon\Carbon;
use App\Notifications\BlockReminder; 
use App\Models\Usuario; 
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB; // Añade esta línea para usar la fachada de DB

class RemindBloques extends Command
{
    protected $signature = 'bloques:remind {time?}'; 
    protected $description = 'Send reminders for upcoming bloques';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $input_time = $this->argument('time'); 

        if ($input_time) {
            $current_time = Carbon::createFromFormat('Y-m-d H:i:s', $input_time);
        } else {
            $current_time = now();
        }

        // Debug: imprimir la hora actual y la hora +10 minutos
        $this->info('Hora actual: ' . $current_time);
        $this->info('Hora +10 minutos: ' . $current_time->copy()->addMinutes(10));

        // Encuentra bloques que comienzan dentro de 10 minutos y tienen recordatorio activado
        $bloques = Bloque::where('recordatorio', true)
                         ->where('inicio', '>', $current_time)
                         ->where('inicio', '<=', $current_time->copy()->addMinutes(10))
                         ->get();

        // Debug: imprimir el número de bloques encontrados
        $this->info('Número de bloques encontrados: ' . $bloques->count());

        foreach ($bloques as $bloque) {
            // Guarda una notificación en la base de datos
            DB::table('notifications')->insert([
                'usuario_id' => $bloque->usuario_id,
                'message' => 'Recordatorio para el bloque: ' . $bloque->titulo,
                'type' => 'info',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $this->info('Recordatorio guardado para el bloque: ' . $bloque->titulo);

            // Opcional: Si aún quieres enviar un correo de recordatorio además de guardar en la base de datos
            $usuario = Usuario::find($bloque->usuario_id);
            if ($usuario) {
                $usuario->notify(new BlockReminder($bloque));
                $this->info('Recordatorio enviado por correo para el bloque: ' . $bloque->titulo);
            }
        }
    }
}
