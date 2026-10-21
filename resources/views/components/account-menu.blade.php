@props(['variant' => 'card']) {{-- card (sidebar) | avatar (topbar) --}}

@php
    $user = auth()->user();
    $name = $user?->name ?? __('stoman.account.guest');
    $email = $user?->email ?? __('stoman.account.not_signed_in');
    $initials = strtoupper(mb_substr($name, 0, 1));
@endphp

<x-dropdown width="w-56" align="right" class="{{ $variant === 'card' ? 'w-full' : '' }}"
    label="{{ $name }}">
    <x-slot:trigger>
        @if($variant === 'card')
            <div class="flex w-full items-center gap-3 rounded-lg p-2 text-left transition-colors hover:bg-slate-50">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-semibold text-primary-700">
                    {{ $initials }}
                </span>
                <span class="min-w-0 flex-1" x-show="!$store.ui.sidebarCollapsed || $store.ui.drawerOpen">
                    <span class="block truncate text-sm font-semibold text-slate-900">{{ $name }}</span>
                    <span class="block truncate text-xs text-slate-600">{{ $email }}</span>
                </span>
                <x-icon x-show="!$store.ui.sidebarCollapsed || $store.ui.drawerOpen" name="chevron-up-down" :size="16"
                    class="shrink-0 text-slate-400" />
            </div>
        @else
            <span
                class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-100 text-sm font-semibold text-primary-700 focus-ring">
                {{ $initials }}
            </span>
        @endif
    </x-slot:trigger>

    <x-slot:panel>
        <div class="px-3 py-2" x-show="{{ $variant === 'card' ? '$store.ui.sidebarCollapsed && !$store.ui.drawerOpen' : 'false' }}">
            <p class="truncate text-sm font-semibold text-slate-900">{{ $name }}</p>
            <p class="truncate text-xs text-slate-600">{{ $email }}</p>
        </div>
        <x-menu-item icon="user" href="{{ route('settings.index') }}">{{ __('stoman.account.profile') }}</x-menu-item>
        <x-menu-item icon="gear" href="{{ route('settings.index') }}">{{ __('stoman.account.settings') }}</x-menu-item>
        <div class="my-1 h-px bg-slate-200"></div>
        <x-menu-item icon="enter" @click="window.stomanApi.logout()">{{ __('stoman.account.sign_out') }}</x-menu-item>
    </x-slot:panel>
</x-dropdown>
