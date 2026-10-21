{{-- PRD 7.6: Create Folder modal (440px, name + color swatches + validation). --}}
<div x-data="folderModal"
    x-init="$watch('$store.modals.folder', (open) => { if (open) { document.getElementById('folder-name-input')?.focus(); } })">
    <x-modal name="folder" :title="__('stoman.folder.title')" width="max-w-[440px]">
        <form class="space-y-4" @submit.prevent="submit()">
            @csrf
            <div>
                <x-input label="{{ __('stoman.folder.label') }}" name="folder_name"
                    placeholder="{{ __('stoman.folder.placeholder') }}" maxlength="100" autocomplete="off"
                    id="folder-name-input" x-model="name" />

                <p x-show="error === 'required'" x-cloak class="mt-1.5 text-xs text-danger-600">
                    {{ __('stoman.folder.required') }}
                </p>
                <p x-show="error === 'invalid_chars'" x-cloak class="mt-1.5 text-xs text-danger-600">
                    {{ __('stoman.folder.invalid_chars') }}
                </p>
                <p x-show="error === 'too_long'" x-cloak class="mt-1.5 text-xs text-danger-600">
                    {{ __('stoman.folder.too_long') }}
                </p>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-slate-900">{{ __('stoman.folder.color') }}</p>
                <div class="flex items-center gap-2" role="radiogroup"
                    aria-label="{{ __('stoman.folder.color') }}">
                    @foreach (['primary' => 'bg-primary-600', 'sky' => 'bg-sky-500', 'violet' => 'bg-violet-500', 'rose' => 'bg-rose-500', 'amber' => 'bg-amber-500', 'slate' => 'bg-slate-500'] as $key => $class)
                        <button type="button" role="radio" x-bind:aria-checked="color === '{{ $key }}'"
                            @click="color = '{{ $key }}'"
                            class="h-6 w-6 rounded-full transition-shadow focus-ring {{ $class }}"
                            :class="color === '{{ $key }}' ? 'ring-2 ring-primary-600 ring-offset-2' : ''"
                            aria-label="{{ __('stoman.folder.color') }}: {{ $key }}"></button>
                    @endforeach
                </div>
            </div>

            <x-slot:footer>
                <x-button variant="secondary" @click="requestClose()">{{ __('stoman.common.cancel') }}</x-button>
                <x-button variant="primary" @click="submit()">{{ __('stoman.common.create') }}</x-button>
            </x-slot:footer>
        </form>
    </x-modal>
</div>
