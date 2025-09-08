<?php

namespace App\Http\Controllers;

use App\Models\Sugestao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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

    /**
     * Mostra o formulário para editar uma sugestão.
     *
     * @param  \App\Models\Sugestao  $sugestao
     * @return \Inertia\Response
     */
    public function edit(Sugestao $sugestao)
    {
        return Inertia::render('Sugestoes/Edit', [
            'sugestao' => $sugestao
        ]);
    }

    /**
     * Atualiza uma sugestão no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sugestao  $sugestao
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sugestao $sugestao)
    {
        $request->validate([
            'youtube_link' => [
                'required',
                'url',
                // Aceita youtube.com/watch?v=..., youtu.be/..., youtube.com/shorts/... e ignora parâmetros extras
                'regex:/^https?:\/\/(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/).+/i',
            ],
            'status' => 'required|in:pendente,aprovado,rejeitado',
        ], [
            'youtube_link.required' => 'O link do YouTube é obrigatório.',
            'youtube_link.url' => 'Por favor, insira uma URL válida.',
            'youtube_link.regex' => 'O link do YouTube informado é inválido.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ]);

        $sugestao->update([
            'youtube_link' => $request->youtube_link,
            'status' => $request->status,
        ]);

        return redirect()->route('welcome')->with('success', 'Sugestão atualizada com sucesso!');
    }

    /**
     * Remove uma sugestão do banco de dados.
     *
     * @param  \App\Models\Sugestao  $sugestao
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Sugestao $sugestao)
    {
        $sugestao->delete();

        return redirect()->route('welcome')->with('success', 'Sugestão excluída com sucesso!');
    }
}
