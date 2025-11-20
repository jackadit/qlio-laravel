<?php

namespace App\Http\Controllers;

use App\Models\SwSoc;
use App\Models\SwPays;
use Illuminate\Http\Request;

class SocieteController extends Controller
{
    public function index(Request $request)
    {
        $query = SwSoc::query();
        
        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('soc_nom', 'like', '%' . $request->search . '%');
        }
        
        // Filtre par pays
        if ($request->filled('pays_id')) {
            $query->where('soc_pays_id', $request->pays_id);
        }
        
        // Filtre par statut
        if ($request->filled('statut')) {
            switch ($request->statut) {
                case 'actif':
                    $query->where('actif', 1);
                    break;
                case 'inactif':
                    $query->where('actif', 0);
                    break;
                case 'prospect':
                    $query->where('prospect', 1);
                    break;
            }
        }
        
        $societes = $query->orderBy('soc_nom')->paginate(10)->withQueryString();
        $pays = SwPays::orderBy('pays_nom')->get();
        
        return view('qlio.societes', compact('societes', 'pays'));
    }

    public function create()
    {
        $pays = SwPays::orderBy('pays_nom')->get();
        return view('qlio.societes-create', compact('pays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'soc_nom' => 'required|string|max:255',
            'soc_adresse' => 'nullable|string|max:255',
            'soc_cp' => 'nullable|string|max:10',
            'soc_commune' => 'nullable|string|max:100',
            'soc_tel' => 'nullable|string|max:40',
            'soc_mel' => 'nullable|email|max:50',
            'soc_pays_id' => 'nullable|exists:sw_pays,pays_id',
            'actif' => 'boolean'
        ]);

        $validated['createur_id'] = 1; // À remplacer par l'ID de l'utilisateur connecté
        
        SwSoc::create($validated);
        
        return redirect()->route('societes.index')->with('success', 'Entreprise créée avec succès');
    }

    public function edit($id)
    {
        $societe = SwSoc::findOrFail($id);
        $pays = SwPays::orderBy('pays_nom')->get();
        
        return view('qlio.societes-edit', compact('societe', 'pays'));
    }

    public function update(Request $request, $id)
    {
        $societe = SwSoc::findOrFail($id);
        
        $validated = $request->validate([
            'soc_nom' => 'required|string|max:255',
            'soc_adresse' => 'nullable|string|max:255',
            'soc_cp' => 'nullable|string|max:10',
            'soc_commune' => 'nullable|string|max:100',
            'soc_tel' => 'nullable|string|max:40',
            'soc_mel' => 'nullable|email|max:50',
            'soc_pays_id' => 'nullable|exists:sw_pays,pays_id',
            'actif' => 'boolean'
        ]);

        $societe->update($validated);
        
        return redirect()->route('societes.index')->with('success', 'Entreprise mise à jour avec succès');
    }

    public function destroy($id)
    {
        $societe = SwSoc::findOrFail($id);
        $societe->delete();
        
        return redirect()->route('societes.index')->with('success', 'Entreprise supprimée avec succès');
    }
}
