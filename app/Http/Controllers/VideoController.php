<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index()
    {
        $musicas = $this->buscarVideosYouTube();

        return Inertia::render('Welcome', [
            'musicas' => $musicas,
            'auth' => [
                'user' => auth()->user(),
            ],
            'laravelVersion' => \Illuminate\Foundation\Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function store(Request $request)
    {
        // Validação do link enviado
        $request->validate([
            'youtube_url' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]{11}$/'
            ]
        ], [
            'youtube_url.required' => 'O link do YouTube é obrigatório',
            'youtube_url.url' => 'Digite uma URL válida',
            'youtube_url.regex' => 'O link deve ser do YouTube'
        ]);

        // Aqui você pode salvar no banco ou processar a URL
        return redirect()->back()->with('success', 'Sugestão enviada com sucesso!');
    }

    /**
     * Busca os vídeos mais populares de Tião Carreiro e Pardinho no YouTube.
     *
     * @return array
     */
    private function buscarVideosYouTube(): array
    {
        $apiKey = config('services.youtube.api_key');

        if (!$apiKey) {
            Log::error('Chave da API do YouTube não configurada.');
            return [];
        }

        try {
            $response = Http::withOptions(['verify' => false]) // apenas para teste local
                ->get('https://www.googleapis.com/youtube/v3/search', [
                    'part' => 'snippet',
                    'q' => 'Tião Carreiro e Pardinho',
                    'type' => 'video',
                    'order' => 'viewCount',
                    'maxResults' => 5,
                    'key' => $apiKey,
                ]);

            if ($response->failed()) {
                Log::error('Falha ao buscar vídeos do YouTube: ' . $response->body());
                return [];
            }

            $items = $response->json()['items'] ?? [];

            return array_map(function ($item) {
                return [
                    'id' => $item['id']['videoId'] ?? null,
                    'title' => $item['snippet']['title'] ?? '',
                    'youtube_id' => $item['id']['videoId'] ?? null,
                ];
            }, $items);

        } catch (\Throwable $e) {
            Log::error('Erro ao buscar vídeos do YouTube: ' . $e->getMessage());
            return [];
        }
    }
}
