<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message');

        // Validasi input
        if (!$message) {
            return response()->json(['reply' => 'Pesan tidak boleh kosong.'], 400);
        }

        // Kirim ke OpenAI API
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        $reply = $response['choices'][0]['message']['content'] ?? 'Maaf, saya tidak dapat memahami permintaan Anda.';

        return response()->json(['reply' => $reply]);
    }
}
