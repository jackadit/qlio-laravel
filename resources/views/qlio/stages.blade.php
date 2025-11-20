@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Stages</h1>
    <p class="text-gray-600">Liste de tous les stages</p>
</div>

<!-- Barre de recherche et filtres -->
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('stages') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Rechercher un stage..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Étudiant</label>
            <select name="etudiant_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->user_id }}" {{ request('etudiant_id') == $etudiant->user_id ? 'selected' : '' }}>
                        {{ $etudiant->user_nom }} {{ $etudiant->user_prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
            <select name="societe_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Toutes</option>
                @foreach($societes as $societe)
                    <option value="{{ $societe->soc_id }}" {{ request('societe_id') == $societe->soc_id ? 'selected' : '' }}>
                        {{ $societe->soc_nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tuteur pédagogique</label>
            <select name="tuteur_peda_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                @foreach($tuteurs as $tuteur)
                    <option value="{{ $tuteur->user_id }}" {{ request('tuteur_peda_id') == $tuteur->user_id ? 'selected' : '' }}>
                        {{ $tuteur->user_nom }} {{ $tuteur->user_prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tuteur entreprise</label>
            <select name="tuteur_soc_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                @foreach($tuteurs as $tuteur)
                    <option value="{{ $tuteur->user_id }}" {{ request('tuteur_soc_id') == $tuteur->user_id ? 'selected' : '' }}>
                        {{ $tuteur->user_nom }} {{ $tuteur->user_prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de début (>=)</label>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin (<=)</label>
            <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="md:col-span-3 flex justify-between items-center">
            <div class="space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Filtrer
                </button>
                <a href="{{ route('stages') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Réinitialiser
                </a>
            </div>
            <a href="{{ route('stages.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Créer un stage
            </a>
        </div>
    </form>
</div>

<!-- Tableau simplifié -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuteur pédagogique</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuteur entreprise</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Début</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($stages as $stage)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stage->sta_nom }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $stage->etudiant ? $stage->etudiant->user_nom.' '.$stage->etudiant->user_prenom : 'Non assigné' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $stage->societe->soc_nom ?? 'Non assignée' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $stage->tuteurPeda ? $stage->tuteurPeda->user_nom.' '.$stage->tuteurPeda->user_prenom : 'Non assigné' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $stage->tuteurSoc ? $stage->tuteurSoc->user_nom.' '.$stage->tuteurSoc->user_prenom : 'Non assigné' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stage->sta_debut ? $stage->sta_debut->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stage->sta_fin ? $stage->sta_fin->format('d/m/Y') : '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <x-table-action-buttons
                        :edit-url="route('stages.edit', $stage->sta_id)"
                        :delete-url="route('stages.delete', $stage->sta_id)"
                        confirm="Êtes-vous sûr de vouloir supprimer ce stage ?"
                    />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $stages->links() }}
</div>
@endsection
