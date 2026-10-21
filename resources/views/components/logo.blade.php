@props([
    'tone' => 'dark',   // dark (on white) | light (on primary-700 panel)
    'showText' => true,
    'textSize' => 'text-lg',   // 18px/700 in sidebar
])

{{-- STOMAN logo: 32x32 mark + wordmark. --}}
<span {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $tone === 'light' ? 'bg-white/15 text-white' : 'bg-primary-600 text-white' }}">
        <x-icon name="server" :size="18" />
    </span>
    @if($showText)
        <span class="{{ $textSize }} font-bold tracking-tight {{ $tone === 'light' ? 'text-white' : 'text-slate-900' }}">
            {{ __('stoman.app.name') }}
        </span>
    @endif
</span>
