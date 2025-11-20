@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Utilisateurs</h1>
    <p class="text-gray-600">Gérer l'ensemble des comptes (étudiants, tuteurs, administrateurs)</p>
</div>

<!-- Filtres -->
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('users') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou prénom"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
            <select name="user_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Tous</option>
                @foreach($userTypes as $typeId => $label)
                    <option value="{{ $typeId }}" {{ (string)request('user_type_id') === (string)$typeId ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
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

        <div class="flex items-end justify-between gap-2 md:col-span-1">
            <div class="space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filtrer</button>
                <a href="{{ route('users') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Réinitialiser</a>
            </div>
        </div>
    </form>
</div>

<!-- Header actions -->
<div class="mb-4 flex justify-between items-center">
    <div class="text-sm text-gray-600">
        {{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }}
        @if(request()->query())
            <span class="ml-2 text-blue-600">(filtre appliqué)</span>
        @endif
    </div>
    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Ajouter un utilisateur
    </a>
</div>

<!-- Tableau -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $user->user_prenom }} {{ $user->user_nom }}</div>
                            <div class="text-xs text-gray-500">#{{ $user->user_id }} @if($user->user_num)- {{ $user->user_num }}@endif</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->user_mel ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $userTypes[$user->user_type_id] ?? 'Inconnu' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->formatted_telephone ?: ($user->user_tel_port ?: '—') }}</td>
                        <td class="px-6 py-4">
                            @if($user->actif)
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Actif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <x-table-action-buttons
                                :edit-url="route('users.edit', $user->user_id)"
                                :delete-url="route('users.destroy', $user->user_id)"
                                confirm="Êtes-vous sûr de vouloir supprimer cet utilisateur ?"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucun utilisateur trouvé. <a href="{{ route('users.create') }}" class="text-blue-600 hover:text-blue-800">Créer un utilisateur</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection
