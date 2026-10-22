@props([
    'align' => 'left',   // left | right
    'width' => 'w-60',   // 240px default (PRD 6.3)
    'label' => null,     // aria-label for the trigger wrapper
    'block' => false,
])

{{-- Generic dropdown (PRD 6.3 / 6.9). Slots: "trigger", "panel".
     Gap = 8px (mt-2); Esc and click-outside close it. --}}
<div {{ $attributes->class(['relative', 'w-full block' => $block, 'inline-block' => !$block]) }} x-data="{ open: false }"
    @click.outside="open = false" @keydown.escape.window="open = false">
    <div @click="open = !open" @keydown.enter.prevent="open = !open" @keydown.space.prevent="open = !open"
        @keydown.arrow-down.prevent="open = true" @if($label) role="button" aria-haspopup="menu" :aria-expanded="open.toString()" aria-label="{{ $label }}" @endif
        class="{{ $block ? 'w-full' : '' }}">
        {{ $trigger }}
    </div>

    <div x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click="open = false"
        class="absolute z-40 mt-2 {{ $align === 'right' ? 'right-0' : 'left-0' }} {{ $width }} rounded-xl border border-slate-200 bg-white p-1 shadow-overlay"
        role="menu">
        {{ $panel }}
    </div>
</div>
