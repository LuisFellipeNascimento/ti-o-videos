import { Head, Link, router } from "@inertiajs/react";
import SuggestionForm from "@/Components/SuggestionForm"; // Importa o formulário

export default function Welcome({
    auth,
    musicas, // Supondo que você passará as músicas do controller
    sugestoes,
    laravelVersion,
    phpVersion,
}) {
    const handleDelete = (sugestao) => {
        if (
            confirm(
                `Tem certeza que deseja excluir a sugestão: "${sugestao.youtube_link}"?`
            )
        ) {
            router.delete(route("sugestoes.destroy", sugestao.id));
        }
    };

    return (
        <>
            <Head title="Welcome" />
            <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <img
                    id="background"
                    className="absolute -left-20 top-0 max-w-[877px]"
                    src="https://laravel.com/assets/img/welcome/background.svg"
                />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header className="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                            <div className="flex lg:col-start-2 lg:justify-center">
                                <h1 className="text-4xl sm:text-5xl font-extrabold text-gray-800 tracking-tight dark:text-white">
                                    🎶 Tião Carreiro e Pardinho
                                </h1>
                            </div>
                            <nav className="-mx-3 flex flex-1 justify-end">
                                <a
                                    href="#sugestoes"
                                    className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Sugerir Música
                                </a>
                                {auth.user ? (
                                    <Link
                                        href={route("dashboard")}
                                        className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Login
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </header>

                        <main className="mt-6">
                            {/* Seção Top 5 Músicas */}
                            {musicas && musicas.length > 0 ? (
                                <div className="mb-12">
                                    <h2 className="text-2xl font-bold text-gray-800 dark:text-white mb-4 text-center">
                                        As 5 mais tocadas
                                    </h2>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                                        {musicas.map((musica) => (
                                            <div key={musica.id} className="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-md transition-all duration-250 hover:scale-[1.01]">
                                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white">{musica.title}</h3>
                                                <div className="aspect-w-16 aspect-h-9 mt-4">
                                                    <iframe
                                                        src={`https://www.youtube.com/embed/${musica.youtube_id}`}
                                                        frameBorder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowFullScreen
                                                        className="w-full h-full rounded"
                                                        loading="lazy"
                                                        title={musica.title}
                                                    ></iframe>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            ) : (
                                <p className="text-center text-gray-500 dark:text-gray-400 mt-10">Nenhuma música para exibir no momento.</p>
                            )}

                            {/* Seção de Sugestões Recentes */}
                            {sugestoes && sugestoes.data.length > 0 && (
                                <div className="mb-12">
                                    <h2 className="text-2xl font-bold text-gray-800 dark:text-white mb-4 text-center">
                                        Sugestões da Comunidade
                                    </h2>
                                    <div className="p-6 bg-white dark:bg-gray-800/50 rounded-lg shadow-md">
                                        <ul className="divide-y divide-gray-200 dark:divide-gray-700">
                                            {sugestoes.data.map((sugestao) => (
                                                <li key={sugestao.id} className="py-3 flex flex-wrap justify-between items-center gap-2">
                                                    <div className="flex-1 min-w-0">
                                                        <div className="flex items-center gap-x-3">
                                                            <a href={sugestao.youtube_link} target="_blank" rel="noopener noreferrer" className="text-indigo-600 dark:text-indigo-400 hover:underline truncate">
                                                                {sugestao.youtube_link}
                                                            </a>
                                                            <span className={`inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                                ${sugestao.status === 'aprovado' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ''}
                                                                ${sugestao.status === 'pendente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : ''}
                                                                ${sugestao.status === 'rejeitado' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : ''}
                                                            `}>
                                                                {sugestao.status.charAt(0).toUpperCase() + sugestao.status.slice(1)}
                                                            </span>
                                                        </div>
                                                        <p className="text-sm text-gray-500 dark:text-gray-400">Sugerido em: {new Date(sugestao.created_at).toLocaleDateString()}</p>
                                                    </div>
                                                    {auth.user && (
                                                        <div className="flex items-center space-x-4 ml-4">
                                                            <Link
                                                                href={route('sugestoes.edit', sugestao.id)}
                                                                className="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline"
                                                            >
                                                                Editar
                                                            </Link>
                                                            <button
                                                                onClick={() => handleDelete(sugestao)}
                                                                className="text-sm font-medium text-red-600 dark:text-red-400 hover:underline"
                                                            >
                                                                Excluir
                                                            </button>
                                                        </div>
                                                    )}
                                                </li>
                                            ))}
                                        </ul>
                                        {/* Links de Paginação */}
                                        <div className="mt-6 flex justify-between items-center">
                                            {sugestoes.prev_page_url ? (
                                                <Link href={sugestoes.prev_page_url} className="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">Anterior</Link>
                                            ) : (
                                                <span className="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 rounded-md cursor-not-allowed">Anterior</span>
                                            )}
                                            <span className="text-sm text-gray-600 dark:text-gray-400">
                                                Página {sugestoes.current_page} de {sugestoes.last_page}
                                            </span>
                                            {sugestoes.next_page_url ? (
                                                <Link href={sugestoes.next_page_url} className="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">Próximo</Link>
                                            ) : (
                                                <span className="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 rounded-md cursor-not-allowed">Próximo</span>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Seção de Sugestão de Música */}
                            <div id="sugestoes" className="pt-8 mb-12">
                                <h2 className="text-2xl font-bold text-gray-800 dark:text-white mb-4 text-center">
                                    Sugira uma música
                                </h2>
                                <div className="p-6 bg-white dark:bg-gray-800/50 rounded-lg shadow-md">
                                    <SuggestionForm />
                                </div>
                            </div>
                        </main>

                        <footer className="py-16 text-center text-sm text-black dark:text-white/70">
                            Desenvolvido por Luis Fellipe com Laravel v{laravelVersion} (PHP v{phpVersion})
                        </footer>
                    </div>
                </div>
            </div>
        </>
    );
}
