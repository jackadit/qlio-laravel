@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Groupes & droits</h1>
    <p class="text-gray-600">Créez des groupes et attribuez-leur des niveaux d'accès par module.</p>
</div>

<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('groupes') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom du groupe"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actifs</option>
                <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Inactifs</option>
            </select>
        </div>
        <div class="flex items-end space-x-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filtrer</button>
            <a href="{{ route('groupes') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Réinitialiser</a>
        </div>
    </form>
</div>

<div class="mb-4 flex justify-between items-center">
    <div class="text-sm text-gray-600">
        {{ $groupes->total() }} groupe{{ $groupes->total() > 1 ? 's' : '' }}
    </div>
    <a href="{{ route('groupes.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Nouveau groupe
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membres</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Droits</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($groupes as $groupe)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $groupe->groupe_nom }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $types[$groupe->groupe_type] ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $groupe->users->count() }}</td>
                        <td class="px-6 py-4">
                            @if($groupe->actif)
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Actif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex flex-wrap gap-2">
                                @foreach($modules as $key => $label)
                                    @php
                                        $level = optional($groupe->droits->firstWhere('module', $key))->niveau ?? 0;
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $level > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500' }}">
                                        {{ Str::limit($label, 18) }} : {{ $levels[$level] ?? 'Aucun' }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-table-action-buttons
                                :edit-url="route('groupes.edit', $groupe->groupe_id)"
                                :delete-url="route('groupes.destroy', $groupe->groupe_id)"
                                confirm="Supprimer ce groupe ?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucun groupe trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $groupes->links() }}
    </div>
</div>
@endsection
