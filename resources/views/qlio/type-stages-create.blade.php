@extends('qlio.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('type-stages') }}" class="text-gray-600 hover:text-gray-800 mr-3">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Créer un Type de Stage</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('type-stages.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="typsta_libelle" class="block text-sm font-medium text-gray-700 mb-2">
                        Libellé <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="typsta_libelle" 
                        name="typsta_libelle" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('typsta_libelle') }}"
                        required
                        maxlength="100"
                    >
                    @error('typsta_libelle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="typsta_obs" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea 
                        id="typsta_obs" 
                        name="typsta_obs" 
                        rows="4" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >{{ old('typsta_obs') }}</textarea>
                    @error('typsta_obs')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="actif" 
                            name="actif" 
                            value="1"
                            {{ old('actif') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="actif" class="ml-2 block text-sm text-gray-700">
                            Actif
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Cochez cette case pour rendre ce type de stage disponible dans les formulaires
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('type-stages') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Créer le type de stage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
