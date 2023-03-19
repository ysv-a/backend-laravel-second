<x-app-layout>



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создание
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <form method="post" action="{{ route('authors.store') }}" class="mt-6 space-y-6">
                    @csrf


                    <div>
                        <x-input-label for="first_name" value="First Name" />
                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div>
                        <x-input-label for="last_name" value="Last Name" />
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>

                    <div>
                        <x-input-label for="patronymic" value="Patronymic" />
                        <x-text-input id="patronymic" name="patronymic" type="text" class="mt-1 block w-full" :value="old('patronymic')" />
                        <x-input-error class="mt-2" :messages="$errors->get('patronymic')" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="biography" value="Biography" />
                        <x-textarea id="biography" name="biography" class="mt-1 block w-full">{{old('biography')}}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                    </div>

                    <div>
                        <x-input-label for="books" value="Books" />
                        <x-select multiple :lists="$books" id="books" name="book_ids[]" class="mt-1 block w-full"></x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('books_ids')" />
                    </div>


                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                </form>

            </div>
        </div>
    </div>



</x-app-layout>
