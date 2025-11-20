<?php

namespace App\Http\Controllers;

use App\Models\SwTypeStage;
use Illuminate\Http\Request;

class TypeStageController extends Controller
{
    public function index()
    {
        try {
            $typesStages = SwTypeStage::orderBy('typsta_libelle')->get();
        } catch (\Exception $e) {
            $typesStages = collect();
        }
        
        return view('qlio.type-stages', compact('typesStages'));
    }

    public function create()
    {
        return view('qlio.type-stages-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'typsta_libelle' => 'required|string|max:100|unique:sw_type_stages,typsta_libelle',
            'typsta_obs' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        $validated['actif'] = $request->has('actif');
        
        try {
            SwTypeStage::create($validated);
            return redirect()->route('type-stages')->with('success', 'Type de stage créé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $typeStage = SwTypeStage::findOrFail($id);
        } catch (\Exception $e) {
            return redirect()->route('type-stages')->with('error', 'Type de stage non trouvé');
        }
        
        return view('qlio.type-stages-edit', compact('typeStage'));
    }

    public function update(Request $request, $id)
    {
        try {
            $typeStage = SwTypeStage::findOrFail($id);
        } catch (\Exception $e) {
            return redirect()->route('type-stages')->with('error', 'Type de stage non trouvé');
        }
        
        $validated = $request->validate([
            'typsta_libelle' => 'required|string|max:100|unique:sw_type_stages,typsta_libelle,'.$id.',typsta_id',
            'typsta_obs' => 'nullable|string',
            'actif' => 'boolean'
        ]);

        $validated['actif'] = $request->has('actif');
        
        $typeStage->update($validated);
        
        return redirect()->route('type-stages')->with('success', 'Type de stage mis à jour avec succès');
    }

    public function destroy($id)
    {
        try {
            $typeStage = SwTypeStage::findOrFail($id);
            $typeStage->delete();
        } catch (\Exception $e) {
            return redirect()->route('type-stages')->with('error', 'Erreur lors de la suppression');
        }
        
        return redirect()->route('type-stages')->with('success', 'Type de stage supprimé avec succès');
    }
}
