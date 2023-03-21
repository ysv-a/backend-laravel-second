<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создание
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <form method="post" action="{{ route('books.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf


                    <div>
                        <x-input-label for="isbn" value="Isbn" />
                        <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn')" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                    </div>

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div>
                        <x-input-label for="price" value="Price" />
                        <x-text-input id="price" step="any" name="price" type="number" class="mt-1 block w-full" :value="old('price')" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                    <div>
                        <x-input-label for="page" value="Page" />
                        <x-text-input id="page" name="page" type="number" class="mt-1 block w-full" :value="old('page')" />
                        <x-input-error class="mt-2" :messages="$errors->get('page')" />
                    </div>
                    <div>
                        <x-input-label for="year" value="Year" />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year')" />
                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                    </div>

                    <div>
                        <x-input-label for="excerpt" value="Excerpt" />
                        <x-textarea id="excerpt" name="excerpt" class="mt-1 block w-full">{{old('excerpt')}}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('excerpt')" />
                    </div>

                    <div>
                        <x-input-label for="image" value="Image" />
                        <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" :value="old('image')" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>


                    <div>
                        <x-input-label for="authors" value="Authors" />
                        <x-select multiple :lists="$authors" id="authors" name="authors_ids[]" class="mt-1 block w-full"></x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('authors_ids')" />
                    </div>

                    <div class="text-2xl">Create Author</div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name0" value="First Name" />
                            <x-text-input id="first_name0" name="authors[0][first_name]" type="text" class="mt-1 block w-full" :value="old('authors.0.first_name')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.0.first_name')" />
                        </div>
                        <div>
                            <x-input-label for="last_name0" value="Last Name" />
                            <x-text-input id="last_name0" name="authors[0][last_name]" type="text" class="mt-1 block w-full" :value="old('authors.0.last_name')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.0.last_name')" />
                        </div>
                        <div>
                            <x-input-label for="patronymic0" value="Patronymic" />
                            <x-text-input id="patronymic0" name="authors[0][patronymic]" type="text" class="mt-1 block w-full" :value="old('authors.0.patronymic')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.0.patronymic')" />
                        </div>
                        <div>
                            <x-input-label for="email0" value="Email" />
                            <x-text-input id="email0" name="authors[0][email]" type="email" class="mt-1 block w-full" :value="old('authors.0.email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.0.email')" />
                        </div>
                    </div>
                    <hr>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name1" value="First Name" />
                            <x-text-input id="first_name1" name="authors[1][first_name]" type="text" class="mt-1 block w-full" :value="old('authors.1.first_name')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.1.first_name')" />
                        </div>
                        <div>
                            <x-input-label for="last_name1" value="Last Name" />
                            <x-text-input id="last_name1" name="authors[1][last_name]" type="text" class="mt-1 block w-full" :value="old('authors.1.last_name')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.1.last_name')" />
                        </div>
                        <div>
                            <x-input-label for="patronymic1" value="Patronymic" />
                            <x-text-input id="patronymic1" name="authors[1][patronymic]" type="text" class="mt-1 block w-full" :value="old('authors.1.patronymic')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.1.patronymic')" />
                        </div>
                        <div>
                            <x-input-label for="email1" value="Email" />
                            <x-text-input id="email1" name="authors[1][email]" type="email" class="mt-1 block w-full" :value="old('authors.1.email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('authors.1.email')" />
                        </div>
                    </div>



                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                </form>

            </div>
        </div>
    </div>




</x-app-layout>
