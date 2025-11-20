@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tableau de bord QLIO</h1>
    <p class="text-gray-600">Bienvenue dans votre système de gestion des stages</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-700 mb-4">Utilisateurs</h5>
        <h2 class="text-4xl font-bold text-blue-600 mb-2">{{ $stats['users_count'] }}</h2>
        <p class="text-gray-600 mb-4">utilisateurs enregistrés</p>
        <a href="{{ route('users') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Voir les utilisateurs
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-700 mb-4">Entreprises</h5>
        <h2 class="text-4xl font-bold text-green-600 mb-2">{{ $stats['societes_count'] }}</h2>
        <p class="text-gray-600 mb-4">entreprises partenaires</p>
        <a href="{{ route('societes') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
            Voir les entreprises
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h5 class="text-lg font-semibold text-gray-700 mb-4">Stages</h5>
        <h2 class="text-4xl font-bold text-yellow-600 mb-2">{{ $stats['stages_count'] }}</h2>
        <p class="text-gray-600 mb-4">stages en cours</p>
        <a href="{{ route('stages') }}" class="inline-block bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
            Voir les stages
        </a>
    </div>
</div>
@endsection
