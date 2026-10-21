@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'error' => null,
    'hint' => null,
])

{{-- PRD 6.2: 40px inputs, label above (14px/500, 6px gap), error below. --}}
@php
    $inputId = $attributes->get('id') ?? ($name ? 'input-'.$name : 'input-'.md5($label ?? uniqid()));
    $classes = 'w-full h-10 rounded-lg border px-3 text-sm bg-white transition-colors focus-ring '.
        ($error
            ? 'border-danger-600 focus:border-danger-600 focus:ring-[3px] focus:ring-danger-50'
            : 'border-slate-200 focus:border-primary-600 focus:ring-[3px] focus:ring-primary-100').
        ' placeholder:text-slate-400 text-slate-900';
@endphp

<div {{ $attributes->only([])->class(['flex flex-col']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="text-sm font-medium text-slate-900 mb-1.5">{{ $label }}</label>
    @endif

    <input {{ $attributes->merge(['class' => $classes, 'id' => $inputId]) }} type="{{ $type }}"
        @if($value !== null) value="{{ $value }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif @if($name) name="{{ $name }}" @endif
        @if($error) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif>

    @if($error)
        <p id="{{ $inputId }}-error" class="text-xs text-danger-600 mt-1.5">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-slate-400 mt-1.5">{{ $hint }}</p>
    @endif
</div>
