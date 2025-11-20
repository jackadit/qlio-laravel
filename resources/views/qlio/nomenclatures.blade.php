@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Nomenclatures</h1>
    <p class="text-gray-600">Gérez vos catégories, labels et références</p>
</div>

<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('nomenclatures') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou référence"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select name="categorie" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Toutes</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Actifs</option>
                <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Inactifs</option>
            </select>
        </div>

        <div class="flex items-end justify-between gap-2">
            <div class="space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filtrer</button>
                <a href="{{ route('nomenclatures') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Réinitialiser</a>
            </div>
        </div>
    </form>
</div>

<div class="mb-4 flex justify-between items-center">
    <div class="text-sm text-gray-600">
        {{ $nomenclatures->total() }} résultat{{ $nomenclatures->total() > 1 ? 's' : '' }}
        @if(request()->query())
            <span class="ml-2 text-blue-600">(filtre appliqué)</span>
        @endif
    </div>
    <a href="{{ route('nomenclatures.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Ajouter une nomenclature
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($nomenclatures as $nomenclature)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $nomenclature->nomenc_cat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $nomenclature->nomenc_nom ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $nomenclature->nomenc_ref ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $nomenclature->ordre ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($nomenclature->actif)
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Actif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-table-action-buttons
                                :edit-url="route('nomenclatures.edit', $nomenclature->nomenc_id)"
                                :delete-url="route('nomenclatures.destroy', $nomenclature->nomenc_id)"
                                confirm="Supprimer cette nomenclature ?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucune nomenclature trouvée. <a href="{{ route('nomenclatures.create') }}" class="text-blue-600 hover:text-blue-800">Créer la première</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $nomenclatures->links() }}
    </div>
</div>
@endsection
