{{-- PRD 7.7: Share / Invite Member modal (520px, chips + role + link access). --}}
<div x-data="shareModal">
    <x-modal name="share" :title="__('stoman.share.title')" width="max-w-[520px]">
        <div class="space-y-5">
            {{-- Email chips input --}}
            <div>
                <label for="share-email" class="mb-1.5 block text-sm font-medium text-slate-900">
                    {{ __('stoman.share.email_label') }}
                </label>
                <input id="share-email" type="email" x-model="email" autocomplete="off"
                    placeholder="{{ __('stoman.share.email_placeholder') }}"
                    @keydown.enter.prevent="addChip()"
                    class="h-10 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 transition-colors placeholder:text-slate-400 focus:border-primary-600 focus:ring-[3px] focus:ring-primary-100 focus:outline-none" />

                <div class="mt-2 flex flex-wrap gap-1.5">
                    <template x-for="member in members" :key="member">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-primary-100 px-2.5 py-1 text-xs font-medium text-primary-700">
                            <span x-text="member"></span>
                            <button type="button" class="rounded-full p-0.5 transition-colors hover:bg-primary-600/20 focus-ring"
                                :aria-label="'Remove ' + member" @click="removeChip(member)">
                                <x-icon name="x" :size="12" />
                            </button>
                        </span>
                    </template>
                </div>
            </div>

            {{-- Role --}}
            <div>
                <label for="share-role" class="mb-1.5 block text-sm font-medium text-slate-900">
                    {{ __('stoman.share.role') }}
                </label>
                <select id="share-role" x-model="role"
                    class="h-10 w-full rounded-lg border border-slate-200 bg-white px-3 text-sm text-slate-900 focus:border-primary-600 focus:ring-[3px] focus:ring-primary-100 focus:outline-none">
                    <option value="viewer">{{ __('stoman.share.role_viewer') }}</option>
                    <option value="commenter">{{ __('stoman.share.role_commenter') }}</option>
                    <option value="editor">{{ __('stoman.share.role_editor') }}</option>
                </select>
            </div>

            {{-- Member list --}}
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p x-show="members.length === 0" class="text-sm text-slate-400">
                    {{ __('stoman.share.members_empty') }}
                </p>
                <ul x-show="members.length > 0" x-cloak class="space-y-2">
                    <template x-for="member in members" :key="member">
                        <li class="flex items-center justify-between gap-2 text-sm text-slate-900">
                            <span class="truncate" x-text="member"></span>
                            <span class="shrink-0 text-xs text-slate-400" x-text="$data.role"></span>
                        </li>
                    </template>
                </ul>
            </div>

            {{-- Link access --}}
            <div class="flex items-center justify-between gap-3 border-t border-slate-200 pt-4">
                <div>
                    <p class="text-sm font-medium text-slate-900">{{ __('stoman.share.link_access') }}</p>
                    <p class="text-xs text-slate-600">{{ __('stoman.share.link_enabled') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" role="switch" x-bind:aria-checked="linkEnabled.toString()"
                        @click="linkEnabled = !linkEnabled"
                        class="relative h-5 w-9 rounded-full transition-colors focus-ring"
                        :class="linkEnabled ? 'bg-primary-600' : 'bg-slate-200'"
                        aria-label="{{ __('stoman.share.link_access') }}">
                        <span class="absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform"
                            :class="linkEnabled ? 'translate-x-4' : 'translate-x-0.5'"></span>
                    </button>
                    <x-button variant="secondary" size="s" icon="link" @click="copyLink()">
                        {{ __('stoman.common.copy_link') }}
                    </x-button>
                </div>
            </div>
        </div>

        <x-slot:footer>
            <span></span>
            <x-button variant="primary" @click="done()">{{ __('stoman.common.done') }}</x-button>
        </x-slot:footer>
    </x-modal>
</div>
