<?php

namespace App\Http\Controllers;

use App\Models\Sugestao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index()
    {
        $musicas = $this->buscarVideosYouTube();
        $sugestoes = Sugestao::latest()->paginate(3); // Pagina as sugestões, 3 por página

        return Inertia::render('Welcome', [
            'musicas' => $musicas,
            'sugestoes' => $sugestoes,
            'auth' => [
                'user' => auth()->user(),
            ],
            'laravelVersion' => \Illuminate\Foundation\Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
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
                    'q' => 'Tião Carreiro e Pardinho musica',
                    'q' => 'Tião Carreiro e Pardinho musica oficial',
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
