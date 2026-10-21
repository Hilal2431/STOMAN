{{-- PRD 7.5: Upload modal (720px, two columns: drop zone | upload list). --}}
<div x-data="uploadModal"
    x-init="$watch('$store.modals.upload', (open) => { if (open) reset(); })"
    @stoman-files.window="addFiles($event.detail.files)"
    @modal-close-request.window="if (event.detail.name === 'upload' && uploading && !confirm(@js(__('stoman.upload.uploading')))) event.preventDefault()">
    <x-modal name="upload" :title="__('stoman.upload.title')" :subtitle="__('stoman.upload.subtitle')" width="max-w-[720px]">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Left: drop zone --}}
            <x-upload-dropzone />

            {{-- Right: upload list --}}
            <div class="flex h-60 flex-col">
                <div x-show="files.length === 0"
                    class="flex h-full items-center justify-center rounded-xl border border-slate-200 bg-slate-50">
                    <p class="text-sm text-slate-400">{{ __('stoman.upload.empty_list') }}</p>
                </div>

                <ul x-show="files.length > 0" x-cloak class="flex h-full flex-col gap-1 overflow-y-auto pr-1">
                    <template x-for="item in files" :key="item.id">
                        <li class="flex items-center gap-3 rounded-lg p-2 transition-colors hover:bg-slate-50">
                            <x-icon name="file" :size="20" class="shrink-0 text-slate-400" />
                            <div class="min-w-0 flex-1">
                                <div class="flex items-baseline justify-between gap-2">
                                    <p class="truncate text-sm font-medium text-slate-900" x-text="item.name"></p>
                                    <span class="shrink-0 text-xs text-slate-400"
                                        x-text="formatSize(item.size)"></span>
                                    <span class="w-10 shrink-0 text-right text-xs text-slate-400"
                                        x-show="item.status === 'uploading'" x-text="item.progress + '%'"></span>
                                </div>
                                <div class="mt-1.5 h-1 overflow-hidden rounded-full bg-slate-100" role="progressbar"
                                    aria-valuemin="0" aria-valuemax="100" x-bind:aria-valuenow="item.progress">
                                    <div class="h-full rounded-full transition-all"
                                        :class="item.status === 'failed' ? 'bg-danger-600' : (item.status === 'done' ? 'bg-success-600' : 'bg-primary-600')"
                                        :style="`width: ${item.progress}%`"></div>
                                </div>
                            </div>

                            {{-- complete -> success check --}}
                            <span x-show="item.status === 'done'" class="shrink-0 text-success-600">
                                <x-icon name="check" :size="18" />
                            </span>

                            {{-- failed -> danger text + try again --}}
                            <span x-show="item.status === 'failed'"
                                class="flex shrink-0 items-center gap-2 text-xs text-danger-600">
                                {{ __('stoman.upload.failed') }}
                                <button type="button"
                                    class="rounded-lg px-1.5 py-1 font-medium text-danger-600 transition-colors hover:bg-danger-50 focus-ring"
                                    @click="retry(item.id)">{{ __('stoman.upload.retry') }}</button>
                            </span>

                            {{-- cancel --}}
                            <button type="button" x-show="item.status === 'pending'"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 focus-ring"
                                aria-label="{{ __('stoman.common.close') }}" @click="remove(item.id)">
                                <x-icon name="x" :size="16" />
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <x-slot:footer>
            <x-button variant="secondary" @click="requestClose()">{{ __('stoman.common.cancel') }}</x-button>
            <div class="flex items-center gap-3">
                <x-button variant="primary" icon="upload" x-show="!uploading"
                    x-bind:disabled="files.length === 0 || uploading" @click="start()">
                    {{ __('stoman.upload.submit') }}
                </x-button>
                <x-button variant="primary" loading disabled x-show="uploading" x-cloak>
                    {{ __('stoman.upload.submit') }}
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
</div>
