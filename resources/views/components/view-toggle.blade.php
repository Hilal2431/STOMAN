@props(['disabled' => false])

{{-- PRD 6.5: Grid/List toggle - right of the section title, before local search.
     Reads/writes `view` from the page's x-data (no local scope). --}}
<div class="inline-flex h-8 items-center gap-0.5 rounded-lg border border-slate-200 bg-white p-0.5"
    role="group" aria-label="{{ __('stoman.common.grid') }}">
    <button type="button" aria-label="{{ __('stoman.common.grid') }}" @click="if (typeof view !== 'undefined') view = 'grid'"
        @if($disabled) disabled @endif x-bind:aria-pressed="((typeof view !== 'undefined' ? view : 'grid') === 'grid').toString()"
        class="flex h-7 w-7 items-center justify-center rounded-md transition-colors focus-ring disabled:opacity-50"
        :class="(typeof view !== 'undefined' ? view : 'grid') === 'grid' ? 'bg-primary-100 text-primary-700' : 'text-slate-400 hover:bg-slate-100 hover:text-slate-600'">
        <x-icon name="grid" :size="16" />
    </button>
    <button type="button" aria-label="{{ __('stoman.common.list') }}" @click="if (typeof view !== 'undefined') view = 'list'"
        @if($disabled) disabled @endif x-bind:aria-pressed="((typeof view !== 'undefined' ? view : 'grid') === 'list').toString()"
        class="flex h-7 w-7 items-center justify-center rounded-md transition-colors focus-ring disabled:opacity-50"
        :class="(typeof view !== 'undefined' ? view : 'grid') === 'list' ? 'bg-primary-100 text-primary-700' : 'text-slate-400 hover:bg-slate-100 hover:text-slate-600'">
        <x-icon name="list" :size="16" />
    </button>
</div>
