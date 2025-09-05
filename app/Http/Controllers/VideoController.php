<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index()
    {
        $musicas = [
            [
                'titulo' => 'TIÃO CARREIRO E PARDINHO - SÓ AS MELHORES',
                'youtube_id' => 'Q7cNcS3-Wpo',
                'visualizacoes' => 1500000
            ],
            [
                'titulo' => 'As 10 Melhores de Tião Carreiro e Pardinho',
                'youtube_id' => 'hN3KKy3ZrEM',
                'visualizacoes' => 1200000
            ],
            [
                'titulo' => 'Seleção de Ouro - Tião Carreiro e Pardinho',
                'youtube_id' => 'SWechmPVNo0',
                'visualizacoes' => 1100000
            ],
            [
                'titulo' => '10 Músicas De TIÃO CARREIRO E PARDINHO Pra Você',
                'youtube_id' => 'zqM4qRwUyis',
                'visualizacoes' => 950000
            ],
            [
                'titulo' => 'Tião Carreiro E Pardinho (Coletânea) - 50 Sucessos',
                'youtube_id' => 'I6JJ_TC39Bk',
                'visualizacoes' => 800000
            ]
        ];
        $musicas = $musicas = Musicas::orderBy('visualizacoes', 'desc')->paginate(5);
        // Em vez de retornar uma view, renderizamos um componente Inertia
        return Inertia::render('Welcome', [
            'musicas' => $musicas,
            'auth' => [
                'user' => auth()->user(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'youtube_url' => ['required', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]{11}$/']
        ], [
            'youtube_url.required' => 'O link do YouTube é obrigatório',
            'youtube_url.url' => 'Digite uma URL válida',
            'youtube_url.regex' => 'O link deve ser do YouTube'
        ]);

        return redirect()->back()->with('success', 'Sugestão enviada com sucesso!');
    }
}
