{{-- PRD 6.7: top right, 16px inset, 360px wide, 4s auto-dismiss, 4px status left border,
     aria-live="polite". --}}
<div x-data class="pointer-events-none fixed right-4 top-4 z-[60] flex w-96 max-w-[calc(100vw-2rem)] flex-col gap-2"
    aria-live="polite">
    <template x-for="toast in $store.ui.toasts" :key="toast.id">
        <div x-data="{
                get colors() {
                    return {
                        success: 'border-l-success-600',
                        danger: 'border-l-danger-600',
                        warning: 'border-l-warning-500',
                        info: 'border-l-primary-600',
                    }[toast.type] || 'border-l-primary-600';
                    },
                get icon() {
                    return { success: 'check', danger: 'exclamation-circle', warning: 'alert', info: 'info' }[toast.type] || 'info';
                },
                get iconColor() {
                    return { success: 'text-success-600', danger: 'text-danger-600', warning: 'text-warning-500', info: 'text-primary-600' }[toast.type] || 'text-primary-600';
                },
            }"
            class="pointer-events-auto flex items-start gap-3 rounded-xl border border-slate-200 border-l-4 bg-white p-3 shadow-overlay"
            :class="colors"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <span class="mt-0.5" :class="iconColor">
                <span x-show="toast.type === 'success'"><x-icon name="check" :size="18" /></span>
                <span x-show="toast.type === 'danger'" x-cloak><x-icon name="exclamation-circle" :size="18" /></span>
                <span x-show="toast.type === 'warning'" x-cloak><x-icon name="alert" :size="18" /></span>
                <span x-show="toast.type === 'info'" x-cloak><x-icon name="info" :size="18" /></span>
            </span>
            <p class="flex-1 text-sm text-slate-900" x-text="toast.message"></p>
            <button type="button" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 focus-ring"
                aria-label="{{ __('stoman.toasts.dismiss') }}" @click="$store.ui.toasts = $store.ui.toasts.filter(t => t.id !== toast.id)">
                <x-icon name="x" :size="16" />
            </button>
        </div>
    </template>
</div>
