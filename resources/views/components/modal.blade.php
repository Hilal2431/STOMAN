@props([
    'name',                              // key in Alpine.store('modals')
    'title',
    'subtitle' => null,
    'width' => 'max-w-[560px]',         // PRD 6.6: 560px default
    'labelId' => null,
])

{{-- PRD 6.6: overlay, radius 16px, padding 24px, X top-right, focus trap,
     Esc/overlay close (guarded when confirmOnClose). Slots: default (body), footer. --}}
@php
    $labelId = $labelId ?? 'modal-'.$name.'-title';
@endphp

<div {{ $attributes }} x-data="{
        requestClose() {
            const e = new CustomEvent('modal-close-request', {
                bubbles: true,
                cancelable: true,
                detail: { name: '{{ $name }}' },
            });
            window.dispatchEvent(e);
            if (!e.defaultPrevented) $store.modals['{{ $name }}'] = false;
        },
    }">
    <div x-show="$store.modals['{{ $name }}']" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        {{-- overlay rgba(15,23,42,.5) --}}
        <div class="absolute inset-0 bg-slate-900/50" @click="requestClose()"></div>

        <div role="dialog" aria-modal="true" aria-labelledby="{{ $labelId }}"
            x-trap.noscroll.inert="$store.modals['{{ $name }}']"
            @keydown.escape.window="if ($store.modals['{{ $name }}']) requestClose()"
            class="relative flex max-h-[90vh] w-full {{ $width }} flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-overlay"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 id="{{ $labelId }}" class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                    @if($subtitle)
                        <p class="mt-1 text-xs text-slate-600">{{ $subtitle }}</p>
                    @endif
                </div>
                <button type="button" class="-m-2 flex h-10 w-10 items-center justify-center rounded-lg text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 focus-ring"
                    aria-label="{{ __('stoman.common.close') }}" @click="requestClose()">
                    <x-icon name="x" :size="20" />
                </button>
            </div>

            <div class="mt-4 overflow-y-auto">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="mt-6 flex items-center justify-between gap-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
