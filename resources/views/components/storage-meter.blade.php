@props([
    'percent' => 0,
    'used' => null,
    'quota' => null,
    'compact' => false,
])

{{-- PRD 5.1: quota card pinned to sidebar bottom.
     Color rule: 0-69% primary-600, 70-89% warning-500, 90-100% danger-600. --}}
@php
    $quota = $quota ?? config('stoman.storage.quota', '10 GB');
    $used = $used ?? __('stoman.quota.usage', ['quota' => $quota]);
    $barColor = $percent >= 90 ? 'bg-danger-600' : ($percent >= 70 ? 'bg-warning-500' : 'bg-primary-600');
@endphp

<div {{ $attributes->class(['rounded-xl border border-slate-200 bg-slate-50 p-3']) }}>
    <div class="mb-2 flex items-center justify-between">
        <span class="text-xs font-medium text-slate-900">{{ __('stoman.quota.label') }}</span>
        @unless($compact)
            <x-icon name="server" :size="14" class="text-slate-400" />
        @endunless
    </div>
    <div role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"
        aria-label="{{ __('stoman.quota.aria') }}"
        class="h-1.5 w-full overflow-hidden rounded-full bg-slate-200">
        <div class="h-full rounded-full {{ $barColor }} transition-all" style="width: {{ $percent }}%"></div>
    </div>
    <p class="mt-2 text-xs text-slate-600">{{ $used }}</p>
</div>
