@props([
    'label' => null,   // aria-label; falls back to visible text
])

{{-- PRD 7.5: click-to-upload or drag-and-drop area (240px, 40% dashed border, primary-50).
     Dispatches 'stoman-files' with a FileList: @stoman-files.window="addFiles($event.detail.files)" --}}
<div x-data="{ dragging: false }"
    class="flex h-60 cursor-pointer flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed px-6 text-center transition-colors"
    :class="dragging ? 'border-primary-600 bg-primary-100' : 'border-primary-600/40 bg-primary-50 hover:bg-primary-100/50'"
    @dragover.prevent.stop="dragging = true" @dragleave.prevent.stop="dragging = false"
    @drop.prevent.stop="dragging = false; $dispatch('stoman-files', { files: $event.dataTransfer.files })"
    @click="$refs.dropInput.click()" @keydown.enter.prevent="$refs.dropInput.click()"
    role="button" tabindex="0" aria-label="{{ $label ?? __('stoman.common.upload_file') }}">
    <input x-ref="dropInput" type="file" multiple class="hidden"
        @change="$dispatch('stoman-files', { files: $event.target.files }); $event.target.value = ''" />
    <x-icon name="cloud-upload" :size="48" class="text-primary-600" />
    <p class="text-sm text-slate-600">{{ __('stoman.upload.dropzone_text') }}</p>
    {{ $slot }}
</div>
