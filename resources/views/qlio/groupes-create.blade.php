@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Créer un groupe</h1>
    <p class="text-gray-600">Définissez un groupe et assignez-lui des droits par module.</p>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <form action="{{ route('groupes.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="groupe_nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du groupe <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="groupe_nom" name="groupe_nom" value="{{ old('groupe_nom') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('groupe_nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="groupe_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type
                    </label>
                    <select id="groupe_type" name="groupe_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ old('groupe_type', 3) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('groupe_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="actif" name="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="actif" class="text-sm text-gray-700">Actif</label>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Droits par module</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($modules as $key => $moduleLabel)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $moduleLabel }}</label>
                            <select name="rights[{{ $key }}]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @foreach($levels as $levelValue => $levelLabel)
                                    <option value="{{ $levelValue }}">{{ $levelLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Membres</h2>
                <x-user-multi-select name="users[]" :users="$users" :selected="old('users', [])" />
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('groupes') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
