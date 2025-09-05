export default function MusicList({ musicas }) {
    return (
        <div className="space-y-10">
            {musicas.map((musica, index) => (
                <div key={musica.youtube_id} className="border-b pb-6">
                    <div className="text-xl font-semibold text-indigo-600">#{index + 1}</div>
                    <h3 className="text-2xl font-medium mt-2">{musica.titulo}</h3>
                    <div className="text-sm text-gray-500 mb-4">
                        {musica.visualizacoes.toLocaleString('pt-BR')} visualizações
                    </div>
                    <iframe
                        width="100%"
                        height="415"
                        src={`https://www.youtube.com/embed/${musica.youtube_id}`}
                        title={musica.titulo}
                        frameBorder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowFullScreen
                        className="rounded-lg shadow-md"
                    ></iframe>
                </div>
            ))}
        </div>
    );
}
