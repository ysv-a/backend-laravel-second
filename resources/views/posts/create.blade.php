<x-app-layout>
    @push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

    </style>
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создание
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6">
                    @csrf


                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" />
                        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                    </div>

                    <div>
                        <x-input-label for="excerpt" value="Excerpt" />
                        <x-textarea id="excerpt" name="excerpt" class="mt-1 block w-full">{{old('excerpt')}}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('excerpt')" />
                    </div>

                    <div>
                        <x-input-label for="category" value="Category" />
                        <x-select :lists="$categories" id="category" name="category" class="mt-1 block w-full"></x-select>
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>

                    <div>
                        <x-input-label for="editor" value="Content" />
                        <x-textarea id="editor" name="content" class="mt-1 block w-full">{{old('content')}}</x-textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    </div>

                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                </form>

            </div>
        </div>
    </div>


    @push('scripts')
    <script src="/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor'))

    </script>
    @endpush

</x-app-layout>
