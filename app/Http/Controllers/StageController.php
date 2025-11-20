<?php

namespace App\Http\Controllers;

use App\Models\SwStage;
use App\Models\SwUser;
use App\Models\SwSoc;
use App\Models\SwTypeStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StageController extends Controller
{
    public function index(Request $request)
    {
        // Version ultra-simplifiée pour diagnostiquer
        $query = SwStage::with(['etudiant', 'societe', 'tuteurPeda', 'tuteurSoc']);

        // UN SEUL FILTRE pour tester
        if ($request->filled('search')) {
            $query->where('sta_nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('etudiant_id')) {
            $query->where('sta_etu_id', $request->etudiant_id);
        }

        if ($request->filled('societe_id')) {
            $query->where('sta_soc_id', $request->societe_id);
        }

        if ($request->filled('tuteur_peda_id')) {
            $query->where('sta_tutpeda_id', $request->tuteur_peda_id);
        }

        if ($request->filled('tuteur_soc_id')) {
            $query->where('sta_tutsoc_id', $request->tuteur_soc_id);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('sta_debut', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('sta_fin', '<=', $request->date_fin);
        }

        // Pagination simple
        $stages = $query->orderBy('sta_debut', 'desc')->paginate(10);
        $stages->appends($request->query());

        $etudiants = SwUser::where('actif', 1)->whereIn('user_type_id', [2, 3])->orderBy('user_nom')->get();
        $societes = SwSoc::where('actif', 1)->orderBy('soc_nom')->get();
        $tuteurs = SwUser::where('actif', 1)->where('user_type_id', 1)->orderBy('user_nom')->get();

        return view('qlio.stages', compact('stages', 'etudiants', 'societes', 'tuteurs'));
    }

    public function create()
    {
        // Les tuteurs (types 2,3) sont en fait les étudiants
        $etudiants = SwUser::where('actif', 1)->whereIn('user_type_id', [2, 3])->orderBy('user_nom')->get();
        $societes = SwSoc::where('actif', 1)->orderBy('soc_nom')->get();
        // Les étudiants (type 1) sont en fait les tuteurs pédagogiques
        $tuteurs = SwUser::where('actif', 1)->where('user_type_id', 1)->orderBy('user_nom')->get();
        
        // Charger les types de stages si la table existe
        try {
            $typesStages = SwTypeStage::where('actif', 1)->orderBy('typsta_libelle')->get();
        } catch (\Exception $e) {
            $typesStages = collect(); // Collection vide si la table n'existe pas
        }
        
        return view('qlio.stages-create', compact('etudiants', 'societes', 'tuteurs', 'typesStages'));
    }

    public function store(Request $request)
    {
        $rules = [
            'sta_nom' => 'required|string|max:255',
            'sta_etu_id' => 'nullable|exists:sw_user,user_id',
            'sta_soc_id' => 'nullable|exists:sw_soc,soc_id',
            'sta_tutpeda_id' => 'nullable|exists:sw_user,user_id',
            'sta_tutsoc_id' => 'nullable|exists:sw_user,user_id',
            'sta_debut' => 'required|date',
            'sta_fin' => 'required|date|after:sta_debut',
            'sta_obs' => 'nullable|string'
        ];

        // Ajouter la règle pour sta_typsta_id seulement si la table existe
        try {
            \Schema::hasTable('sw_type_stages');
            $rules['sta_typsta_id'] = 'nullable|exists:sw_type_stages,typsta_id';
        } catch (\Exception $e) {
            // Si la table n'existe pas, le champ est simplement nullable
            $rules['sta_typsta_id'] = 'nullable';
        }

        $validated = $request->validate($rules);
        $validated['createur_id'] = 1; // À remplacer par l'ID de l'utilisateur connecté
        
        // Si sta_typsta_id est null, mettre une valeur par défaut
        if (empty($validated['sta_typsta_id'])) {
            unset($validated['sta_typsta_id']); // Le modèle gérera la valeur par défaut
        }
        
        SwStage::create($validated);
        
        return redirect()->route('stages')->with('success', 'Stage créé avec succès');
    }

    public function edit($id)
    {
        $stage = SwStage::findOrFail($id);
        // Les tuteurs (types 2,3) sont en fait les étudiants
        $etudiants = SwUser::where('actif', 1)->whereIn('user_type_id', [2, 3])->orderBy('user_nom')->get();
        $societes = SwSoc::where('actif', 1)->orderBy('soc_nom')->get();
        // Les étudiants (type 1) sont en fait les tuteurs pédagogiques
        $tuteurs = SwUser::where('actif', 1)->where('user_type_id', 1)->orderBy('user_nom')->get();
        
        // Charger les types de stages si la table existe
        try {
            $typesStages = SwTypeStage::where('actif', 1)->orderBy('typsta_libelle')->get();
        } catch (\Exception $e) {
            $typesStages = collect(); // Collection vide si la table n'existe pas
        }
        
        return view('qlio.stages-edit', compact('stage', 'etudiants', 'societes', 'tuteurs', 'typesStages'));
    }

    public function update(Request $request, $id)
    {
        $stage = SwStage::findOrFail($id);
        
        $rules = [
            'sta_nom' => 'required|string|max:255',
            'sta_etu_id' => 'nullable|exists:sw_user,user_id',
            'sta_soc_id' => 'nullable|exists:sw_soc,soc_id',
            'sta_tutpeda_id' => 'nullable|exists:sw_user,user_id',
            'sta_tutsoc_id' => 'nullable|exists:sw_user,user_id',
            'sta_debut' => 'required|date',
            'sta_fin' => 'required|date|after:sta_debut',
            'sta_obs' => 'nullable|string'
        ];

        // Ajouter la règle pour sta_typsta_id seulement si la table existe
        try {
            \Schema::hasTable('sw_type_stages');
            $rules['sta_typsta_id'] = 'nullable|exists:sw_type_stages,typsta_id';
        } catch (\Exception $e) {
            // Si la table n'existe pas, le champ est simplement nullable
            $rules['sta_typsta_id'] = 'nullable';
        }

        $validated = $request->validate($rules);

        // Si sta_typsta_id est null, le retirer pour ne pas écraser la valeur existante
        if (empty($validated['sta_typsta_id'])) {
            unset($validated['sta_typsta_id']);
        }

        $stage->update($validated);
        
        return redirect()->route('stages')->with('success', 'Stage mis à jour avec succès');
    }

    public function destroy($id)
    {
        $stage = SwStage::findOrFail($id);
        $stage->delete();
        
        return redirect()->route('stages')->with('success', 'Stage supprimé avec succès');
    }
}
