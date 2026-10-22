@props([
    'size' => 'm',        // m (40px) | s (32px)
    'block' => false,     // full width (sidebar)
    'triggerId' => null,  // id for the keyboard shortcut target
])

{{-- PRD 6.3: "New" menu - 240px dropdown, 8px below the button, left-aligned.
     Office entries only appear when config('stoman.features.office_docs'). --}}
<<<<<<< HEAD
<x-dropdown width="w-60" align="left" :block="$block">
=======
<x-dropdown width="w-60" align="left">
>>>>>>> 53d5b31c16628dcaef7f8f96fbb92d5dd621943d
    <x-slot:trigger>
        <x-button :size="$size" icon="plus" :id="$triggerId" :class="$block ? 'w-full' : ''">
            {{ __('stoman.nav.new') }}
        </x-button>
    </x-slot:trigger>

    <x-slot:panel>
        <x-menu-item icon="folder-plus" @click="$store.modals.folder = true">
            {{ __('stoman.common.new_folder') }}
        </x-menu-item>
        <x-menu-item icon="upload" data-upload-trigger @click="$store.modals.upload = true">
            {{ __('stoman.common.upload_file') }}
        </x-menu-item>
        <x-menu-item icon="folder" data-upload-trigger @click="$store.modals.upload = true">
            {{ __('stoman.common.upload_folder') }}
        </x-menu-item>

        @if(config('stoman.features.office_docs'))
            <div class="my-1 h-px bg-slate-200"></div>
            <x-menu-item icon="file">{{ __('stoman.office.document') }}</x-menu-item>
            <x-menu-item icon="table">{{ __('stoman.office.spreadsheet') }}</x-menu-item>
            <x-menu-item icon="presentation">{{ __('stoman.office.slide') }}</x-menu-item>
            <x-menu-item icon="clipboard">{{ __('stoman.office.form') }}</x-menu-item>
        @endif
    </x-slot:panel>
</x-dropdown>
