<?php

namespace App\Http\Controllers;

use App\Models\Sugestao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SugestaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'youtube_link' => [
                    'bail',
                    'required',
                    'url',
                    'max:255',
                    // Aceita youtube.com/watch?v=..., youtu.be/..., youtube.com/shorts/...
                    'regex:/^https?:\/\/(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/).+/i',
                ],
            ],
            [
                'youtube_link.required' => 'O link do YouTube é obrigatório.',
                'youtube_link.url' => 'Informe um URL válido.',
                'youtube_link.max' => 'O link do YouTube deve ter no máximo 255 caracteres.',
                'youtube_link.regex' => 'O link do YouTube informado é inválido.',
            ],
            [
                'youtube_link' => 'link do YouTube',
            ]
        );

        Sugestao::create([
            'youtube_link' => $request->string('youtube_link')->trim(),
        ]);

        return Redirect::back()->with('success', 'Sugestão enviada com sucesso!');
    }
}
