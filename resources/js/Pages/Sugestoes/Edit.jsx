import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm, Link } from "@inertiajs/react";

export default function Edit({ auth, sugestao }) {
    const { data, setData, put, processing, errors } = useForm({
        youtube_link: sugestao.youtube_link || "",
        status: sugestao.status || "pendente",
    });

    const submit = (e) => {
        e.preventDefault();
        put(route("sugestoes.update", sugestao.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Editar Sugestão
                </h2>
            }
        >
            <Head title="Editar Sugestão" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <form onSubmit={submit}>
                                <div className="mb-4">
                                    <label
                                        htmlFor="youtube_link"
                                        className="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Link do YouTube
                                    </label>
                                    <input
                                        id="youtube_link"
                                        type="url"
                                        name="youtube_link"
                                        value={data.youtube_link}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white sm:text-sm"
                                        onChange={(e) =>
                                            setData("youtube_link", e.target.value)
                                        }
                                        required
                                    />
                                    {errors.youtube_link && (
                                        <p className="mt-2 text-sm text-red-600 dark:text-red-400">
                                            {errors.youtube_link}
                                        </p>
                                    )}
                                </div>

                                <div className="mb-6">
                                    <label
                                        htmlFor="status"
                                        className="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Status
                                    </label>
                                    <select
                                        id="status"
                                        name="status"
                                        value={data.status}
                                        onChange={(e) =>
                                            setData("status", e.target.value)
                                        }
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white sm:text-sm"
                                    >
                                        <option value="pendente">Pendente</option>
                                        <option value="aprovado">Aprovado</option>
                                        <option value="rejeitado">Rejeitado</option>
                                    </select>
                                    {errors.status && (
                                        <p className="mt-2 text-sm text-red-600 dark:text-red-400">
                                            {errors.status}
                                        </p>
                                    )}
                                </div>

                                <div className="flex items-center justify-end space-x-4">
                                    <Link
                                        href={route('welcome')}
                                        className="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500"
                                    >
                                        Cancelar
                                    </Link>
                                    <button
                                        type="submit"
                                        className="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                                        disabled={processing}
                                    >
                                        Salvar Alterações
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
