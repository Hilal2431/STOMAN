@props([
    'title',
    'description' => null,
    'hint' => null,
    'icon' => 'folder',
    'variant' => 'large', // large (centered page state) | small (section state)
])

{{-- PRD 3.1: every empty area gets illustration + title + description + one CTA. --}}
@if($variant === 'small')
    <div {{ $attributes->class(['flex flex-col items-center justify-center gap-2 py-8 text-center']) }}>
        <x-icon :name="$icon" :size="24" class="text-slate-400" />
        <p class="text-sm text-slate-400">{{ $title }}</p>
        @if($hint)
            <p class="text-xs text-slate-400">{{ $hint }}</p>
        @endif
        @if($slot->isNotEmpty())
            <div class="mt-1">{{ $slot }}</div>
        @endif
    </div>
@else
    <div {{ $attributes->class(['flex flex-col items-center justify-center gap-3 py-12 text-center']) }}>
        <div class="flex h-40 w-40 items-center justify-center rounded-full bg-primary-50 text-primary-600">
            <x-icon :name="$icon" :size="72" />
        </div>
        <h2 class="text-xl font-semibold text-slate-900">{{ $title }}</h2>
        @if($description)
            <p class="max-w-md text-sm text-slate-600">{{ $description }}</p>
        @endif
        @if($hint)
            <p class="text-xs text-slate-400">{{ $hint }}</p>
        @endif
        @if($slot->isNotEmpty())
            <div class="mt-1 flex items-center gap-3">{{ $slot }}</div>
        @endif
    </div>
@endif
