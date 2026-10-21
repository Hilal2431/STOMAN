@extends('layouts.app')

@section('title', __('stoman.errors.403.title'))

@section('content')
    <div class="flex min-h-[60vh] flex-col items-center justify-center gap-4 text-center">
        <div class="flex h-40 w-40 items-center justify-center rounded-full bg-slate-100">
            <x-icon name="shield" :size="64" class="text-slate-400" />
        </div>
        <p class="text-[28px] font-bold leading-9 text-slate-400">403</p>
        <h1 class="text-xl font-semibold text-slate-900">{{ __('stoman.errors.403.title') }}</h1>
        <p class="max-w-md text-sm text-slate-600">{{ __('stoman.errors.403.message') }}</p>
        <x-button href="{{ route('home') }}" icon="home" class="mt-2">{{ __('stoman.common.back_home') }}</x-button>
    </div>
@endsection
