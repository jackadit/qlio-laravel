@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Entreprises</h1>
    <p class="text-gray-600">Liste de toutes les entreprises partenaires</p>
</div>

<!-- Messages de succès -->
@if(session('success'))
    <div class="alert-success mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <!-- Formulaire de recherche et filtres -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <form method="GET" action="{{ route('societes') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche par nom -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            Recherche
                        </label>
                        <input 
                            type="text" 
                            id="search" 
                            name="search"
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nom de l'entreprise..."
                        >
                    </div>

                    <!-- Filtre par ville -->
                    <div>
                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-2">
                            Ville
                        </label>
                        <input 
                            type="text" 
                            id="ville" 
                            name="ville"
                            value="{{ request('ville') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ville..."
                        >
                    </div>

                    <!-- Filtre par code postal -->
                    <div>
                        <label for="cp" class="block text-sm font-medium text-gray-700 mb-2">
                            Code Postal
                        </label>
                        <input 
                            type="text" 
                            id="cp" 
                            name="cp"
                            value="{{ request('cp') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Code postal..."
                        >
                    </div>

                    <!-- Filtre par statut -->
                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                            Statut
                        </label>
                        <select 
                            id="statut" 
                            name="statut"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Tous les statuts</option>
                            <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actifs</option>
                            <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactifs</option>
                            <option value="prospect" {{ request('statut') == 'prospect' ? 'selected' : '' }}>Prospects</option>
                        </select>
                    </div>
                </div>

                <!-- Deuxième ligne de filtres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Filtre par pays -->
                    <div>
                        <label for="pays_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pays
                        </label>
                        <select 
                            id="pays_id" 
                            name="pays_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Tous les pays</option>
                            @foreach($pays as $p)
                                <option value="{{ $p->pays_id }}" {{ request('pays_id') == $p->pays_id ? 'selected' : '' }}>
                                    {{ $p->pays_nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Espace vide pour alignement -->
                    <div></div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('societes') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                        Réinitialiser
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- Bouton Ajouter et résultats -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <span class="text-sm text-gray-600">
                    {{ $societes->count() }} {{ $societes->count() > 1 ? 'entreprises trouvées' : 'entreprise trouvée' }}
                    @if(request()->filled('search') || request()->filled('ville') || request()->filled('cp') || request()->filled('pays_id') || request()->filled('statut'))
                        <a href="{{ route('societes') }}" class="ml-2 text-blue-600 hover:text-blue-800">
                            (Voir toutes)
                        </a>
                    @endif
                </span>
            </div>
            <a href="{{ route('societes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter une entreprise
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Adresse</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Commune</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Code Postal</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Téléphone</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Actif</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($societes as $societe)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-800">{{ $societe->soc_id }}</td>
                        <td class="py-3 px-4">
                            <span class="font-semibold text-gray-800">{{ $societe->soc_nom }}</span>
                        </td>
                        <td class="py-3 px-4 text-gray-800">{{ $societe->soc_adresse ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-800">{{ $societe->soc_commune ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-800">{{ $societe->soc_cp ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $societe->formatted_tel ?: '-' }}</div>
                        </td>
                        <td class="py-3 px-4 text-gray-800">{{ $societe->soc_mel ?? '-' }}</td>
                        <td class="py-3 px-4">
                            @if($societe->actif)
                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Oui</span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Non</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <x-table-action-buttons
                                :edit-url="route('societes.edit', $societe->soc_id)"
                                :delete-url="route('societes.delete', $societe->soc_id)"
                                confirm="Êtes-vous sûr de vouloir supprimer cette entreprise ?"
                            />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex justify-center">
            {{ $societes->links() }}
        </div>
    </div>
</div>
@endsection
