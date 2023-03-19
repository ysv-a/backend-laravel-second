<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактирование: {{$book->title}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                @if($book->image)
                <div class="mt-5">
                    <img src="{{asset('storage/' . $book->image)}}" alt="">
                </div>
                @endif

                <form method="post" action="{{ route('books.update', ['book' => $book]) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="isbn" value="Isbn" />
                        <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn', $book->isbn)" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                    </div>

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $book->title)" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div>
                        <x-input-label for="price" value="Price" />
                        <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price', $book->price)" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                    <div>
                        <x-input-label for="page" value="Page" />
                        <x-text-input id="page" name="page" type="number" class="mt-1 block w-full" :value="old('page', $book->page)" />
                        <x-input-error class="mt-2" :messages="$errors->get('page')" />
                    </div>
                    <div>
                        <x-input-label for="year" value="Year" />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year', $book->year)" />
                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                    </div>

                    <div>
                        <x-input-label for="excerpt" value="Excerpt" />
                        <x-textarea id="excerpt" name="excerpt" class="mt-1 block w-full">{{old('excerpt', $book->excerpt)}}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('excerpt')" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Image" />
                        <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" :value="old('image', $book->image)" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <div>
                        <x-input-label for="authors" value="Authors" />
                        <x-select multiple :selected="$selectedAuthorsIds" :lists="$authors" id="authors" name="authors_ids[]" class="mt-1 block w-full"></x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('authors')" />
                    </div>


                    <x-primary-button>{{ __('Save') }}</x-primary-button>


                </form>

                @unless($book->is_published)
                <form class="mt-10 flex justify-end" action="{{route('books.publish', ['book' => $book])}}" method="POST">
                    @method('PATCH')
                    @csrf
                    <x-primary-button>Publish</x-primary-button>
                </form>
                @endunless

            </div>
        </div>
    </div>




</x-app-layout>
