<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Книги
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex justify-end">
                    <x-primary-link href="{{ route('books.create') }}">Create</x-primary-link>
                </div>
                <table class="w-full mt-5 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Authors</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isbn</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published?</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Remove</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($books as $book)
                        <tr>
                            <td class="px-6 py-4  text-sm text-gray-500">
                                {{
                                    $book
                                    ->authors
                                    ->map(fn($author) => "{$author->first_name} {$author->last_name} {$author->patronymic}")
                                    ->join(', ')
                                 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->isbn}}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->title}}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->price->formatted}}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->page}}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->year}}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{$book->is_published ? 'Yes' : 'No'}}</td>

                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{route('books.edit', ['book' => $book])}}" class="text-slate-600 hover:text-slate-900">Edit</a>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form action="{{route('books.destroy', ['book' => $book])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4  text-sm font-medium text-gray-900">No books</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-10">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
