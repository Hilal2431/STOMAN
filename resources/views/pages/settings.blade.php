@extends('layouts.app')

@section('title', __('stoman.settings.title'))

@section('content')
    @php
        $tabs = [
            'profile' => __('stoman.settings.tab_profile'),
            'security' => __('stoman.settings.tab_security'),
            'storage' => __('stoman.settings.tab_storage'),
            'notifications' => __('stoman.settings.tab_notifications'),
        ];
    @endphp

    <div class="space-y-6">
        <h1 class="text-[28px] font-bold leading-9 text-slate-900">{{ __('stoman.settings.title') }}</h1>

        <div x-data="{ tab: 'profile' }" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
            {{-- Vertical tabs (200px) --}}
            <nav class="w-full shrink-0 lg:w-[200px]" aria-label="{{ __('stoman.settings.title') }}">
                <ul class="flex gap-2 overflow-x-auto pb-1 lg:flex-col lg:pb-0">
                    @foreach ($tabs as $key => $label)
                        <li class="shrink-0 lg:w-full">
                            <button type="button" @click="tab = '{{ $key }}'"
                                x-bind:aria-current="tab === '{{ $key }}' ? 'page' : false"
                                class="flex h-10 w-full items-center gap-2.5 whitespace-nowrap rounded-lg px-3 text-sm font-medium transition-colors focus-ring"
                                :class="tab === '{{ $key }}' ? 'bg-primary-100 text-primary-700' : 'text-slate-600 hover:bg-slate-100'">
                                @switch($key)
                                    @case('profile')
                                        <x-icon name="user" :size="18" />
                                    @break
                                    @case('security')
                                        <x-icon name="shield" :size="18" />
                                    @break
                                    @case('storage')
                                        <x-icon name="server" :size="18" />
                                    @break
                                    @default
                                        <x-icon name="bell" :size="18" />
                                @endswitch
                                {{ $label }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="w-full max-w-[640px] flex-1">
                {{-- Profile --}}
                <section x-show="tab === 'profile'" x-cloak
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-card">
                    <h2 class="text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.settings.profile_title') }}</h2>
                    <p class="mt-1 text-sm text-slate-600">{{ __('stoman.settings.profile_desc') }}</p>

                    <form class="mt-6 space-y-4" @submit.prevent>
                        @csrf
                        <x-input label="{{ __('stoman.settings.name_label') }}" name="name" id="settings-name"
                            :value="auth()->user()?->name ?? ''" autocomplete="name" />
                        <x-input label="{{ __('stoman.settings.email_label') }}" name="email" id="settings-email"
                            type="email" :value="auth()->user()?->email ?? ''" autocomplete="email" />

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <x-button variant="secondary"
                                @click="tab = 'profile'">{{ __('stoman.settings.cancel') }}</x-button>
                            <x-button type="submit"
                                @click="$store.ui.toast('success', window.STOMAN_I18N?.saved)">{{ __('stoman.common.save') }}</x-button>
                        </div>
                    </form>
                </section>

                {{-- Security --}}
                <section x-show="tab === 'security'" x-cloak
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-card">
                    <h2 class="text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.settings.security_title') }}</h2>
                    <p class="mt-1 text-sm text-slate-600">{{ __('stoman.settings.security_desc') }}</p>

                    <form class="mt-6 space-y-4" @submit.prevent>
                        @csrf
                        <x-input label="{{ __('stoman.settings.current_password') }}" name="current_password"
                            id="settings-current-password" type="password" autocomplete="current-password" />
                        <x-input label="{{ __('stoman.settings.new_password') }}" name="new_password"
                            id="settings-new-password" type="password" autocomplete="new-password" />
                        <x-input label="{{ __('stoman.settings.confirm_password') }}" name="confirm_password"
                            id="settings-confirm-password" type="password" autocomplete="new-password" />

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <x-button variant="secondary"
                                @click="tab = 'profile'">{{ __('stoman.settings.cancel') }}</x-button>
                            <x-button type="submit"
                                @click="$store.ui.toast('success', window.STOMAN_I18N?.saved)">{{ __('stoman.common.save') }}</x-button>
                        </div>
                    </form>
                </section>

                {{-- Storage --}}
                <section x-show="tab === 'storage'" x-cloak
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-card">
                    <h2 class="text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.settings.storage_title') }}</h2>
                    <p class="mt-1 text-sm text-slate-600">{{ __('stoman.settings.storage_desc') }}</p>

                    <x-storage-meter class="mt-5" :percent="0" />

                    <div class="mt-5 border-t border-slate-200 pt-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <span>{{ __('stoman.settings.file_type') }}</span>
                            <span>{{ __('stoman.settings.used') }}</span>
                        </div>
                        @forelse ($fileTypeUsage as $row)
                            <div class="flex items-center justify-between border-b border-slate-100 py-2.5 text-sm last:border-0">
                                <span class="text-slate-900" data-type>{{ data_get($row, 'type', '') }}</span>
                                <span class="text-slate-600">{{ data_get($row, 'used_label', '0 B') }}</span>
                            </div>
                        @empty
                            <p class="py-3 text-center text-sm text-slate-400">0 B</p>
                        @endforelse
                    </div>
                </section>

                {{-- Notifications --}}
                <section x-show="tab === 'notifications'" x-cloak
                    class="rounded-xl border border-slate-200 bg-white p-6 shadow-card">
                    <h2 class="text-xl font-semibold leading-7 text-slate-900">{{ __('stoman.settings.notifications_title') }}</h2>
                    <p class="mt-1 text-sm text-slate-600">{{ __('stoman.settings.notifications_desc') }}</p>

                    <form class="mt-6 space-y-4" @submit.prevent>
                        @csrf
                        @foreach ([
                            'uploads' => __('stoman.settings.notify_uploads'),
                            'shares' => __('stoman.settings.notify_shares'),
                            'trash' => __('stoman.settings.notify_trash'),
                        ] as $key => $label)
                            <label class="flex items-center gap-3 text-sm text-slate-900">
                                <input type="checkbox" name="notify[{{ $key }}]"
                                    class="h-4 w-4 rounded border-slate-300 accent-primary-600 focus-ring" />
                                {{ $label }}
                            </label>
                        @endforeach

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <x-button variant="secondary"
                                @click="tab = 'notifications'">{{ __('stoman.settings.cancel') }}</x-button>
                            <x-button type="submit"
                                @click="$store.ui.toast('success', window.STOMAN_I18N?.saved)">{{ __('stoman.common.save') }}</x-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
