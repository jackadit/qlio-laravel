@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Modifier une nomenclature</h1>
    <p class="text-gray-600">Mettre à jour l'entrée sélectionnée</p>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <form action="{{ route('nomenclatures.update', $nomenclature->nomenc_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nomenc_cat" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nomenc_cat" name="nomenc_cat" value="{{ old('nomenc_cat', $nomenclature->nomenc_cat) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('nomenc_cat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ordre" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordre
                    </label>
                    <input type="number" id="ordre" name="ordre" value="{{ old('ordre', $nomenclature->ordre) }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('ordre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomenc_nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom
                    </label>
                    <input type="text" id="nomenc_nom" name="nomenc_nom" value="{{ old('nomenc_nom', $nomenclature->nomenc_nom) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('nomenc_nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomenc_ref" class="block text-sm font-medium text-gray-700 mb-2">
                        Référence
                    </label>
                    <input type="text" id="nomenc_ref" name="nomenc_ref" value="{{ old('nomenc_ref', $nomenclature->nomenc_ref) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('nomenc_ref')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="actif" name="actif" value="1" {{ old('actif', $nomenclature->actif) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="actif" class="text-sm text-gray-700">Actif</label>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('nomenclatures') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
