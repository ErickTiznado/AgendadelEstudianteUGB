<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class OpenAIController extends Controller
{
    public function index()
{
    return view('openai');
}
public function chat(Request $request)
{
    $userMessage = $request->input('user_message');
    $apiKey = env('OPENAI_API_KEY');
    
    $client = new Client();
    
    try {
        $response = $client->post('http://localhost:3001/chat', [  // Asegúrate de que esta URL sea correcta
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => [
                'user_message' => $userMessage,  // Cambiado a 'user_message' para coincidir con el servidor Node.js
            ],
        ]);
        
        $body = json_decode((string) $response->getBody(), true);
        
        return response()->json($body);  // Aquí, $body debería tener una propiedad 'message' que contiene el mensaje del asistente
    } catch (\Exception $e) {
        return response()->json(['error' => 'Hubo un error al comunicarse con el asistente virtual. Por favor, inténtalo de nuevo más tarde.'], 500);
    }
}
}
