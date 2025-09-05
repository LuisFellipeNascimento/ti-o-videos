<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Top 5 - Tião Carreiro e Pardinho</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="container">
        <header>
            <h1>Tião Carreiro e Pardinho</h1>
            <p>As 5 músicas mais tocadas da dupla caipira</p>
        </header>

        <main>
            <div class="music-list">
                @foreach($musicas as $musica)
                    <div class="music-item">
                        <h3>{{ $musica['titulo'] }}</h3>
                        <div class="video-wrapper">
                            <iframe 
                                width="560" 
                                height="315" 
                                src="https://www.youtube.com/embed/{{ $musica['youtube_id'] }}"
                                title="{{ $musica['titulo'] }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="suggestion-form">
                <h2>Sugerir Nova Música</h2>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('sugestoes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="youtube_url">Link do YouTube:</label>
                        <input 
                            type="url" 
                            id="youtube_url" 
                            name="youtube_url" 
                            required 
                            placeholder="https://www.youtube.com/watch?v=..."
                        >
                    </div>
                    <button type="submit">Enviar Sugestão</button>
                </form>
            </div>
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} - Todos os direitos reservados</p>
        </footer>
    </div>
</body>
</html>