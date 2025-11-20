@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Modifier un stage</h1>
    <p class="text-gray-600">Mettre à jour les informations du stage</p>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <form action="{{ route('stages.update', $stage->sta_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="sta_nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Intitulé du stage <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="sta_nom" 
                        name="sta_nom" 
                        value="{{ old('sta_nom', $stage->sta_nom) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('sta_nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_etu_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Étudiant (anciens tuteurs)
                    </label>
                    <select 
                        id="sta_etu_id" 
                        name="sta_etu_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- Sélectionner un étudiant --</option>
                        @foreach($etudiants as $etudiant)
                            <option value="{{ $etudiant->user_id }}" {{ old('sta_etu_id', $stage->sta_etu_id) == $etudiant->user_id ? 'selected' : '' }}>
                                {{ $etudiant->user_nom }} {{ $etudiant->user_prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('sta_etu_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_soc_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Entreprise
                    </label>
                    <select 
                        id="sta_soc_id" 
                        name="sta_soc_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- Sélectionner une entreprise --</option>
                        @foreach($societes as $societe)
                            <option value="{{ $societe->soc_id }}" {{ old('sta_soc_id', $stage->sta_soc_id) == $societe->soc_id ? 'selected' : '' }}>
                                {{ $societe->soc_nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('sta_soc_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_typsta_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de stage
                    </label>
                    <select 
                        id="sta_typsta_id" 
                        name="sta_typsta_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- Sélectionner un type --</option>
                        @foreach($typesStages as $type)
                            <option value="{{ $type->typsta_id }}" {{ old('sta_typsta_id', $stage->sta_typsta_id) == $type->typsta_id ? 'selected' : '' }}>
                                {{ $type->typsta_libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('sta_typsta_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_tutpeda_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tuteur pédagogique (anciens étudiants)
                    </label>
                    <select 
                        id="sta_tutpeda_id" 
                        name="sta_tutpeda_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- Sélectionner un tuteur --</option>
                        @foreach($tuteurs as $tuteur)
                            <option value="{{ $tuteur->user_id }}" {{ old('sta_tutpeda_id', $stage->sta_tutpeda_id) == $tuteur->user_id ? 'selected' : '' }}>
                                {{ $tuteur->user_nom }} {{ $tuteur->user_prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('sta_tutpeda_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_tutsoc_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tuteur entreprise
                    </label>
                    <select 
                        id="sta_tutsoc_id" 
                        name="sta_tutsoc_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- Sélectionner un tuteur --</option>
                        @foreach($tuteurs as $tuteur)
                            <option value="{{ $tuteur->user_id }}" {{ old('sta_tutsoc_id', $stage->sta_tutsoc_id) == $tuteur->user_id ? 'selected' : '' }}>
                                {{ $tuteur->user_nom }} {{ $tuteur->user_prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('sta_tutsoc_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_debut" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="sta_debut" 
                        name="sta_debut" 
                        value="{{ old('sta_debut', $stage->sta_debut) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('sta_debut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sta_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="sta_fin" 
                        name="sta_fin" 
                        value="{{ old('sta_fin', $stage->sta_fin) }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('sta_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="sta_obs" class="block text-sm font-medium text-gray-700 mb-2">
                        Observations
                    </label>
                    <textarea 
                        id="sta_obs" 
                        name="sta_obs" 
                        rows="4" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Description du stage, missions, etc."
                    >{{ old('sta_obs', $stage->sta_obs) }}</textarea>
                    @error('sta_obs')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('stages') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
