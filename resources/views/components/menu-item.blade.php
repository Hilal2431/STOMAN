@props([
    'icon' => null,
    'danger' => false,
    'href' => null,
])

{{-- Dropdown row (PRD 6.3/6.9): 40px high, icon + label. --}}
@php
    $classes = 'flex w-full items-center gap-2.5 h-10 px-3 rounded-lg text-sm text-left transition-colors focus-ring '.($danger ? 'text-danger-600 hover:bg-danger-50' : 'text-slate-700 hover:bg-slate-100');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }} role="menuitem">
        @if($icon)<x-icon :name="$icon" :size="18" class="{{ $danger ? 'text-danger-600' : 'text-slate-400' }}" />@endif
        <span class="truncate">{{ $slot }}</span>
    </a>
@else
    <button type="button" {{ $attributes->class([$classes]) }} role="menuitem">
        @if($icon)<x-icon :name="$icon" :size="18" class="{{ $danger ? 'text-danger-600' : 'text-slate-400' }}" />@endif
        <span class="truncate">{{ $slot }}</span>
    </button>
@endif
