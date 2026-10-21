<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('stoman.app.name'))</title>

    <script>
        window.STOMAN_I18N = @js([
            'notWired' => __('stoman.auth.not_wired'),
            'showPassword' => __('stoman.auth.show_password'),
            'hidePassword' => __('stoman.auth.hide_password'),
        ]);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen">
        {{-- >= 1024px: left primary-700 panel with logo + tagline (PRD 7.1) --}}
        <div class="hidden w-1/2 flex-col bg-primary-700 p-10 lg:flex">
            <x-logo tone="light" />
            <div class="flex flex-1 items-center justify-center">
                <p class="px-8 text-center text-2xl font-semibold leading-9 text-white">
                    {{ __('stoman.app.tagline') }}
                </p>
            </div>
        </div>

        <div class="flex w-full items-center justify-center p-6 lg:w-1/2">
            <div class="w-full max-w-[400px]">
                {{-- < 1024px: logo above the form --}}
                <div class="mb-8 flex justify-center lg:hidden">
                    <x-logo />
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <x-toast />

    @stack('scripts')
</body>

</html>
