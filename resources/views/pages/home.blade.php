@extends('layouts.app')

@section('title', __('stoman.nav.home'))

@section('content')
    @php
        $displayName = auth()->user()?->name ?? __('stoman.account.guest');
    @endphp

<<<<<<< HEAD
    <div class="space-y-8" x-data="{ view: 'grid' }">
=======
    <div class="space-y-8">
>>>>>>> 53d5b31c16628dcaef7f8f96fbb92d5dd621943d
        {{-- Header + quota widget --}}
        <header class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-bold leading-9 text-slate-900">
                    {{ __('stoman.home.welcome', ['name' => $displayName]) }}
                </h1>
                <p class="mt-1 text-sm text-slate-600">{{ __('stoman.home.subtitle') }}</p>
            </div>

            <div class="flex shrink-0 items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" class="-rotate-90" role="progressbar"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" aria-label="{{ __('stoman.quota.aria') }}">
                    <circle cx="12" cy="12" r="10" fill="none" stroke-width="3" class="stroke-slate-200" />
                    <circle cx="12" cy="12" r="10" fill="none" stroke-width="3" stroke-linecap="round"
                        class="stroke-primary-600" stroke-dasharray="62.83" stroke-dashoffset="62.83" />
                </svg>
                <span class="text-xs text-slate-600">{{ __('stoman.quota.used_percent') }}</span>
            </div>
        </header>

        {{-- Quick action cards (PRD 7.2) --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <button type="button" data-upload-trigger @click="$store.modals.upload = true"
                class="flex h-[120px] items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 text-left shadow-card transition-all hover:shadow-card-hover focus-ring">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700">
                    <x-icon name="upload" :size="22" />
                </span>
                <span class="min-w-0">
                    <span class="block text-base font-semibold text-slate-900">{{ __('stoman.common.upload_file') }}</span>
                    <span class="mt-0.5 block truncate text-sm text-slate-600">{{ __('stoman.home.upload_file_desc') }}</span>
                </span>
            </button>

            <button type="button" @click="$store.modals.folder = true"
                class="flex h-[120px] items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 text-left shadow-card transition-all hover:shadow-card-hover focus-ring">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700">
                    <x-icon name="folder-plus" :size="22" />
                </span>
                <span class="min-w-0">
                    <span class="block text-base font-semibold text-slate-900">{{ __('stoman.common.create_folder') }}</span>
                    <span class="mt-0.5 block truncate text-sm text-slate-600">{{ __('stoman.home.create_folder_desc') }}</span>
                </span>
            </button>

            <button type="button" @click="$store.modals.share = true"
                class="flex h-[120px] items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 text-left shadow-card transition-all hover:shadow-card-hover focus-ring">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-700">
                    <x-icon name="users" :size="22" />
                </span>
                <span class="min-w-0">
                    <span class="block text-base font-semibold text-slate-900">{{ __('stoman.common.invite_member') }}</span>
                    <span class="mt-0.5 block truncate text-sm text-slate-600">{{ __('stoman.home.invite_member_desc') }}</span>
                </span>
            </button>
        </div>

        {{-- Starred Folders --}}
        <section>
            <h2 class="mb-2 text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.home.starred_title') }}</h2>
            <x-empty-state variant="small" icon="star" :title="__('stoman.home.no_starred')" />
        </section>

        {{-- Collaborative Folders --}}
        <section>
            <h2 class="mb-2 text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.home.collab_title') }}</h2>
            <x-empty-state variant="small" icon="users" :title="__('stoman.home.no_collab')">
                <x-button variant="secondary" icon="folder-plus" @click="$store.modals.folder = true">
                    {{ __('stoman.common.create_folder') }}
                </x-button>
            </x-empty-state>
        </section>

        {{-- Recently Opened Files --}}
        <section>
            <div class="mb-2 flex items-center justify-between gap-3">
                <h2 class="text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.home.recent_title') }}</h2>
                <div class="flex items-center gap-2">
                    <x-view-toggle disabled />
                    <input type="search" disabled
                        placeholder="{{ __('stoman.common.search_placeholder') }}"
                        aria-label="{{ __('stoman.common.search_placeholder') }}"
                        class="hidden h-8 w-56 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm text-slate-900 placeholder:text-slate-400 disabled:cursor-not-allowed disabled:opacity-50 md:block" />
                </div>
            </div>
            <x-empty-state variant="small" icon="file" :title="__('stoman.home.no_files')">
                <x-button icon="upload" data-upload-trigger @click="$store.modals.upload = true">
                    {{ __('stoman.common.upload_file') }}
                </x-button>
            </x-empty-state>
        </section>
    </div>
@endsection
