<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Files') }}
        </h2>

    </header>

    <form method="post" action="{{ route('profile.add.document') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="file" value="Files" />
            <x-text-input id="file" name="file" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('file')" />
        </div>

        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </form>

    <ul class="mt-10">
        @foreach($documents as $document)
        <a href="{{ route('profile.get.document', $document->uuid) }}">
            <li>{{$document->file_name}}</li>
        </a>
        @endforeach
    </ul>
</section>
