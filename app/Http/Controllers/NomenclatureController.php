<?php

namespace App\Http\Controllers;

use App\Models\SwNomenclature;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    public function index(Request $request)
    {
        $query = SwNomenclature::query();

        if ($request->filled('search')) {
            $pattern = '%' . str_replace(['*', '?'], ['%', '_'], addcslashes($request->search, '%_\\')) . '%';
            $query->where(function ($q) use ($pattern) {
                $q->where('nomenc_nom', 'like', $pattern)
                  ->orWhere('nomenc_ref', 'like', $pattern);
            });
        }

        if ($request->filled('categorie')) {
            $query->where('nomenc_cat', $request->categorie);
        }

        if ($request->filled('statut')) {
            $query->where('actif', $request->statut === 'actif' ? 1 : 0);
        }

        $nomenclatures = $query->orderBy('nomenc_cat')->orderBy('ordre')->orderBy('nomenc_nom')
            ->paginate(10)->appends($request->query());

        $categories = SwNomenclature::select('nomenc_cat')->distinct()->orderBy('nomenc_cat')->pluck('nomenc_cat');

        return view('qlio.nomenclatures', compact('nomenclatures', 'categories'));
    }

    public function create()
    {
        $categories = SwNomenclature::select('nomenc_cat')->distinct()->orderBy('nomenc_cat')->pluck('nomenc_cat');
        return view('qlio.nomenclatures-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomenc_cat' => 'required|string|max:63',
            'nomenc_nom' => 'nullable|string|max:255',
            'nomenc_ref' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'sometimes|boolean',
        ]);

        $validated['actif'] = $request->boolean('actif');

        SwNomenclature::create($validated);

        return redirect()->route('nomenclatures')->with('success', 'Nomenclature créée avec succès');
    }

    public function edit(SwNomenclature $nomenclature)
    {
        $categories = SwNomenclature::select('nomenc_cat')->distinct()->orderBy('nomenc_cat')->pluck('nomenc_cat');
        return view('qlio.nomenclatures-edit', compact('nomenclature', 'categories'));
    }

    public function update(Request $request, SwNomenclature $nomenclature)
    {
        $validated = $request->validate([
            'nomenc_cat' => 'required|string|max:63',
            'nomenc_nom' => 'nullable|string|max:255',
            'nomenc_ref' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'sometimes|boolean',
        ]);

        $validated['actif'] = $request->boolean('actif');

        $nomenclature->update($validated);

        return redirect()->route('nomenclatures')->with('success', 'Nomenclature mise à jour avec succès');
    }

    public function destroy(SwNomenclature $nomenclature)
    {
        $nomenclature->delete();

        return redirect()->route('nomenclatures')->with('success', 'Nomenclature supprimée avec succès');
    }
}
