@props(['disabled' => false])

{{-- PRD 7.3: Sort dropdown (Name, Date, Size) - S-size trigger. --}}
<div x-data="{
        sort: 'name',
        labels: {
            name: @js(__('stoman.common.sort_name')),
            date: @js(__('stoman.common.sort_date')),
            size: @js(__('stoman.common.sort_size')),
        },
    }">
    <x-dropdown width="w-44" align="right">
    <x-slot:trigger>
        <x-button variant="secondary" size="s" icon="sort" :disabled="$disabled">
            <span x-text="labels[sort]"></span>
            <x-icon name="chevron-down" :size="14" class="text-slate-400" />
        </x-button>
    </x-slot:trigger>

    <x-slot:panel>
        <x-menu-item icon="sort" @click="sort = 'name'">{{ __('stoman.common.sort_name') }}</x-menu-item>
        <x-menu-item icon="clock" @click="sort = 'date'">{{ __('stoman.common.sort_date') }}</x-menu-item>
        <x-menu-item icon="server" @click="sort = 'size'">{{ __('stoman.common.sort_size') }}</x-menu-item>
    </x-slot:panel>
</x-dropdown>
</div>
