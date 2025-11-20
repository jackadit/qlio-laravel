@php($componentId = uniqid('user-multi-'))
<div class="space-y-3">
    <div class="flex items-center gap-2">
        <input type="text" id="{{ $componentId }}-search" placeholder="Rechercher un utilisateur"
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        <button type="button" class="px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50" data-select-all="{{ $componentId }}">Tout cocher</button>
        <button type="button" class="px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50" data-unselect-all="{{ $componentId }}">Tout décocher</button>
    </div>
    <div class="border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2" id="{{ $componentId }}-list">
            @foreach($users as $user)
                <label class="flex items-center space-x-2 text-sm text-gray-700" data-user-item data-name="{{ \Illuminate\Support\Str::lower($user->user_prenom.' '.$user->user_nom) }}">
                    <input type="checkbox" name="{{ $name }}" value="{{ $user->user_id }}"
                           {{ in_array($user->user_id, $selected ?? []) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span>{{ $user->user_prenom }} {{ $user->user_nom }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[id$="-search"]').forEach(input => {
                    input.addEventListener('input', () => {
                        const list = document.getElementById(input.id.replace('-search', '-list'));
                        if (!list) return;
                        const term = input.value.toLowerCase();
                        list.querySelectorAll('[data-user-item]').forEach(item => {
                            const name = item.dataset.name;
                            item.classList.toggle('hidden', !name.includes(term));
                        });
                    });
                });

                document.querySelectorAll('[data-select-all]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const list = document.getElementById(btn.dataset.selectAll + '-list');
                        list?.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = true);
                    });
                });

                document.querySelectorAll('[data-unselect-all]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const list = document.getElementById(btn.dataset.unselectAll + '-list');
                        list?.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                    });
                });
            });
        </script>
    @endpush
@endonce
