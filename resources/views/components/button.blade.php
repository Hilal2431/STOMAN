@props([
    'variant' => 'primary',   // primary | secondary | ghost | danger
    'size' => 'm',            // m (40px) | s (32px) | icon (40px) | icon-s (32px)
    'type' => 'button',
    'href' => null,           // renders an <a> instead of <button>
    'disabled' => false,
    'loading' => false,
    'icon' => null,           // x-icon name shown before the label
])

{{-- PRD 6.1: button variants, sizes, focus ring, disabled and loading states. --}}
@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg text-sm font-medium transition-colors focus-ring cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800',
        'secondary' => 'bg-white text-slate-900 border border-slate-200 hover:bg-slate-50',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100',
        'danger' => 'bg-danger-600 text-white hover:bg-danger-700',
    ];

    $sizes = [
        'm' => 'h-10 px-4',
        's' => 'h-8 px-3',
        'icon' => 'h-10 w-10 p-0',
        'icon-s' => 'h-8 w-8 p-0',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['m']);
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => $classes]) }}
    @if($tag === 'a') href="{{ $href }}" @else type="{{ $type }}" @endif
    @if($tag === 'button' && ($disabled || $loading)) disabled @endif>
    @if($loading)
        <x-icon name="spinner" :size="16" class="animate-spin" />
    @elseif($icon)
        <x-icon :name="$icon" :size="$size === 'm' || $size === 'icon' ? 18 : 16" />
    @endif
    {{ $slot }}
</{{ $tag }}>
