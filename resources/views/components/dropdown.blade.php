@props([
    'align' => 'left',   // left | right
    'width' => 'w-60',   // 240px default (PRD 6.3)
    'label' => null,     // aria-label for the trigger wrapper
])

{{-- Generic dropdown (PRD 6.3 / 6.9). Slots: "trigger", "panel".
     Gap = 8px (mt-2); Esc and click-outside close it. --}}
<div {{ $attributes->class(['relative inline-block']) }} x-data="{ open: false }"
    @click.outside="open = false" @keydown.escape.window="open = false">
    <div @click="open = !open" @keydown.enter.prevent="open = !open" @keydown.space.prevent="open = !open"
        @keydown.arrow-down.prevent="open = true" tabindex="0" @if($label) role="button" aria-haspopup="menu" :aria-expanded="open.toString()" aria-label="{{ $label }}" @endif
        class="focus-ring rounded-lg">
        {{ $trigger }}
    </div>

    <div x-show="open" x-cloak x-transition.origin.top.start="-5%" @click="open = false"
        class="absolute z-40 mt-2 {{ $align === 'right' ? 'right-0' : 'left-0' }} {{ $width }} rounded-xl border border-slate-200 bg-white p-1 shadow-overlay"
        role="menu">
        {{ $panel }}
    </div>
</div>
