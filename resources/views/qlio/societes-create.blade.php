@extends('qlio.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Ajouter une entreprise</h1>
    <p class="text-gray-600">Créer une nouvelle entreprise partenaire</p>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <form action="{{ route('societes.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="soc_nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de l'entreprise <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="soc_nom" 
                        name="soc_nom" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nom de l'entreprise"
                    >
                    @error('soc_nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_num" class="block text-sm font-medium text-gray-700 mb-2">
                        Numéro
                    </label>
                    <input 
                        type="text" 
                        id="soc_num" 
                        name="soc_num"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Numéro interne"
                    >
                    @error('soc_num')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_cp" class="block text-sm font-medium text-gray-700 mb-2">
                        Code postal
                    </label>
                    <input 
                        type="text" 
                        id="soc_cp" 
                        name="soc_cp"
                        value="{{ old('soc_cp') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="75000"
                    >
                    @error('soc_cp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_pays_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pays
                    </label>
                    <select 
                        id="soc_pays_id" 
                        name="soc_pays_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Sélectionner un pays</option>
                        @foreach($pays as $p)
                            <option value="{{ $p->pays_id }}" {{ old('soc_pays_id') == $p->pays_id ? 'selected' : '' }}>
                                {{ $p->pays_nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('soc_pays_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_commune" class="block text-sm font-medium text-gray-700 mb-2">
                        Commune
                    </label>
                    <input 
                        type="text" 
                        id="soc_commune" 
                        name="soc_commune"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Paris"
                    >
                    @error('soc_commune')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_tel" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <input 
                        type="tel" 
                        id="soc_tel" 
                        name="soc_tel"
                        value="{{ old('soc_tel') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="03 88 12 34 56"
                        pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}"
                        title="Format : XX XX XX XX XX"
                    >
                    @error('soc_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_fax" class="block text-sm font-medium text-gray-700 mb-2">
                        Fax
                    </label>
                    <input 
                        type="tel" 
                        id="soc_fax" 
                        name="soc_fax"
                        value="{{ old('soc_fax') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="03 88 12 34 57"
                        pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}"
                        title="Format : XX XX XX XX XX"
                    >
                    @error('soc_fax')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_mel" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="soc_mel" 
                        name="soc_mel"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="contact@entreprise.fr"
                    >
                    @error('soc_mel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_web" class="block text-sm font-medium text-gray-700 mb-2">
                        Site web
                    </label>
                    <input 
                        type="url" 
                        id="soc_web" 
                        name="soc_web"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://www.entreprise.fr"
                    >
                    @error('soc_web')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="soc_adresse" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse
                    </label>
                    <input 
                        type="text" 
                        id="soc_adresse" 
                        name="soc_adresse"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="123 rue de la République"
                    >
                    @error('soc_adresse')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="soc_adressebis" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse (complément)
                    </label>
                    <input 
                        type="text" 
                        id="soc_adressebis" 
                        name="soc_adressebis"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Bâtiment B, 3ème étage"
                    >
                    @error('soc_adressebis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_bp" class="block text-sm font-medium text-gray-700 mb-2">
                        Boîte postale
                    </label>
                    <input 
                        type="text" 
                        id="soc_bp" 
                        name="soc_bp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="BP 123"
                    >
                    @error('soc_bp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_siret" class="block text-sm font-medium text-gray-700 mb-2">
                        SIRET
                    </label>
                    <input 
                        type="text" 
                        id="soc_siret" 
                        name="soc_siret"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="12345678901234"
                    >
                    @error('soc_siret')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_tva" class="block text-sm font-medium text-gray-700 mb-2">
                        TVA
                    </label>
                    <input 
                        type="text" 
                        id="soc_tva" 
                        name="soc_tva"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="FR12345678901"
                    >
                    @error('soc_tva')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_naf" class="block text-sm font-medium text-gray-700 mb-2">
                        Code NAF
                    </label>
                    <input 
                        type="text" 
                        id="soc_naf" 
                        name="soc_naf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="1234A"
                    >
                    @error('soc_naf')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_iban" class="block text-sm font-medium text-gray-700 mb-2">
                        IBAN
                    </label>
                    <input 
                        type="text" 
                        id="soc_iban" 
                        name="soc_iban"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="FR7630006000011234567890189"
                    >
                    @error('soc_iban')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_bic" class="block text-sm font-medium text-gray-700 mb-2">
                        BIC
                    </label>
                    <input 
                        type="text" 
                        id="soc_bic" 
                        name="soc_bic"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="BNPAFRPP"
                    >
                    @error('soc_bic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="soc_obs" class="block text-sm font-medium text-gray-700 mb-2">
                        Observations
                    </label>
                    <textarea 
                        id="soc_obs" 
                        name="soc_obs"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Notes et observations sur l'entreprise"
                    ></textarea>
                    @error('soc_obs')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_lat" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude
                    </label>
                    <input 
                        type="number" 
                        id="soc_lat" 
                        name="soc_lat"
                        step="0.000001"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="48.8566"
                    >
                    @error('soc_lat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="soc_lng" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude
                    </label>
                    <input 
                        type="number" 
                        id="soc_lng" 
                        name="soc_lng"
                        step="0.000001"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="2.3522"
                    >
                    @error('soc_lng')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="soc_defaut" 
                                name="soc_defaut" 
                                value="1"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="soc_defaut" class="ml-2 text-sm text-gray-700">
                                Défaut
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="actif" 
                                name="actif" 
                                value="1"
                                checked
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="actif" class="ml-2 text-sm text-gray-700">
                                Actif
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="lock" 
                                name="lock" 
                                value="1"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="lock" class="ml-2 text-sm text-gray-700">
                                Verrouillé
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="prospect" 
                                name="prospect" 
                                value="1"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="prospect" class="ml-2 text-sm text-gray-700">
                                Prospect
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                @if(session('success'))
                    <div class="alert-success mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                <a href="{{ route('societes') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Créer l'entreprise
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
