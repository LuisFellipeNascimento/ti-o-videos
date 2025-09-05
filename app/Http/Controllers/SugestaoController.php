<?php

namespace App\Http\Controllers;

use App\Models\Sugestao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SugestaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'youtube_link' => ['required', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/'],
        ]);

        Sugestao::create([
            'youtube_link' => $request->youtube_link,
        ]);

        return Redirect::back();
    }
}
