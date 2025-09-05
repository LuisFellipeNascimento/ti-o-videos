import { useForm } from '@inertiajs/react';
import React from 'react';

export default function SuggestionForm() {
    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        youtube_link: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('sugestoes.store'), {
            preserveScroll: true,
            onSuccess: () => setData('youtube_link', ''),
        });
    };

    return (
        <section className="mt-16 bg-white p-8 rounded-xl shadow-lg">
            <h2 className="text-2xl font-bold text-gray-800 mb-4">Tem uma sugestão?</h2>
            <p className="text-gray-600 mb-6">Envie um link do YouTube e, se for aprovada, ela entrará na nossa lista!</p>

            {recentlySuccessful && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    Sugestão enviada com sucesso! Obrigado.
                </div>
            )}

            <form onSubmit={submit}>
                <div className="flex flex-col sm:flex-row gap-4">
                    <input
                        type="text"
                        name="youtube_link"
                        value={data.youtube_link}
                        onChange={(e) => setData('youtube_link', e.target.value)}
                        placeholder="Cole o link do YouTube aqui"
                        className="flex-grow rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                    />
                    <button
                        type="submit"
                        className="px-6 py-2 bg-yellow-600 text-white font-semibold rounded-md hover:bg-yellow-700 disabled:opacity-50"
                        disabled={processing}
                    >
                        Enviar Sugestão
                    </button>
                </div>
                {errors.youtube_link && <p className="text-sm text-red-600 mt-2">{errors.youtube_link}</p>}
            </form>
        </section>
    );
}