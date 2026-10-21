{{-- PRD 5.4: right detail panel, 360px, slides in (200ms).
     >= 1280px it docks in the content row; below it overlays the content. --}}
<div x-cloak x-show="$store.ui.detailOpen"
    class="fixed inset-0 z-30 bg-slate-900/50 transition-opacity xl:hidden"
    @click="$store.ui.closeDetail()"></div>

<aside x-cloak x-data="{ tab: 'details' }" x-show="$store.ui.detailOpen" role="region"
    aria-label="{{ __('stoman.detail.tabs_details') }}"
    class="fixed inset-y-0 right-0 z-40 flex w-[360px] max-w-full flex-col border-l border-slate-200 bg-white shadow-overlay xl:static xl:z-auto xl:shadow-none"
    x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition duration-150 ease-in"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

    <div class="flex justify-end p-3">
        <button type="button"
            class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 focus-ring"
            aria-label="{{ __('stoman.common.close') }}" @click="$store.ui.closeDetail()">
            <x-icon name="x" :size="20" />
        </button>
    </div>

    {{-- Tabs: Details - Activity - Comments (container slate-100, active white) --}}
    <div class="mx-4 flex rounded-lg bg-slate-100 p-1" role="tablist">
        @foreach ([
            'details' => __('stoman.detail.tabs_details'),
            'activity' => __('stoman.detail.tabs_activity'),
            'comments' => __('stoman.detail.tabs_comments'),
        ] as $key => $label)
            <button type="button" role="tab" :aria-selected="tab === '{{ $key }}'"
                @click="tab = '{{ $key }}'"
                class="h-9 flex-1 rounded-lg px-2 text-sm transition-colors focus-ring"
                :class="tab === '{{ $key }}' ? 'bg-white font-medium text-slate-900 shadow-card' : 'text-slate-600 hover:text-slate-900'">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="mt-4 flex-1 overflow-y-auto px-4 pb-6">
        {{-- Details tab --}}
        <div x-show="tab === 'details'" class="space-y-6">
            <div>
                <p class="text-sm font-semibold text-slate-900">{{ __('stoman.detail.not_available') }}</p>
                <p class="text-xs text-slate-400">{{ __('stoman.detail.not_available') }}</p>
            </div>

            {{-- Preview (200px, empty state shows file type icon) --}}
            <div class="flex h-[200px] flex-col items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-400">
                <x-icon name="file" :size="40" />
                <p class="text-xs">{{ __('stoman.detail.preview_empty') }}</p>
            </div>

            {{-- Shared with --}}
            <div>
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-sm font-semibold text-slate-900">{{ __('stoman.detail.shared_with') }}</h4>
                    <x-button variant="secondary" size="s" @click="$store.modals.share = true">
                        {{ __('stoman.common.invite_member') }}
                    </x-button>
                </div>
                <p class="mt-2 text-xs text-slate-400">{{ __('stoman.detail.not_shared') }}</p>
            </div>

            {{-- File info --}}
            <div>
                <h4 class="mb-2 text-sm font-semibold text-slate-900">{{ __('stoman.detail.file_info') }}</h4>
                <dl class="divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white px-4">
                    @foreach ([
                        'type' => __('stoman.detail.type'),
                        'size' => __('stoman.detail.size'),
                        'owner' => __('stoman.detail.owner'),
                        'last_modified' => __('stoman.detail.last_modified'),
                        'last_opened' => __('stoman.detail.last_opened'),
                        'location' => __('stoman.detail.location'),
                    ] as $label)
                        <div class="flex items-center justify-between gap-3 py-2.5">
                            <dt class="text-sm text-slate-600">{{ $label }}</dt>
                            <dd class="text-sm text-slate-400">{{ __('stoman.detail.not_available') }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Suspicious activity --}}
            <div>
                <h4 class="mb-2 text-sm font-semibold text-slate-900">{{ __('stoman.detail.suspicious') }}</h4>
                <div class="rounded-xl bg-slate-50 p-3 text-sm text-slate-400">
                    {{ __('stoman.detail.suspicious_empty') }}
                </div>
            </div>
        </div>

        {{-- Activity tab --}}
        <div x-show="tab === 'activity'" x-cloak>
            <x-empty-state variant="small" icon="clock" :title="__('stoman.detail.not_available')" />
        </div>

        {{-- Comments tab --}}
        <div x-show="tab === 'comments'" x-cloak>
            <x-empty-state variant="small" icon="mail" :title="__('stoman.detail.not_available')" />
        </div>
    </div>
</aside>
