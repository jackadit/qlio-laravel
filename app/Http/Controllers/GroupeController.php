<?php

namespace App\Http\Controllers;

use App\Models\SwDroit;
use App\Models\SwGroupe;
use App\Models\SwUser;
use App\Services\AccessManager;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    private array $modules;
    private array $levelLabels;
    private array $typeOptions = [
        1 => 'Étudiants',
        2 => 'Tuteurs pédagogiques',
        3 => 'Personnel QLIO',
        4 => 'Invités',
        5 => 'Administrateurs',
    ];

    public function __construct()
    {
        $this->modules = AccessManager::modules();
        $this->levelLabels = AccessManager::levelLabels();
    }

    public function index(Request $request)
    {
        $query = SwGroupe::with(['droits', 'users']);

        if ($request->filled('search')) {
            $pattern = '%' . str_replace(['*', '?'], ['%', '_'], addcslashes($request->search, '%_\\')) . '%';
            $query->where('groupe_nom', 'like', $pattern);
        }

        if ($request->filled('statut')) {
            $query->where('actif', $request->statut === 'actif' ? 1 : 0);
        }

        $groupes = $query->orderBy('groupe_nom')
            ->paginate(10)
            ->appends($request->query());

        return view('qlio.groupes', [
            'groupes' => $groupes,
            'modules' => $this->modules,
            'levels' => $this->levelLabels,
            'types' => $this->typeOptions,
        ]);
    }

    public function create()
    {
        $users = SwUser::orderBy('user_nom')->orderBy('user_prenom')->get();

        return view('qlio.groupes-create', [
            'modules' => $this->modules,
            'levels' => $this->levelLabels,
            'types' => $this->typeOptions,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'groupe_nom' => 'required|string|max:30',
            'groupe_type' => 'required|integer|between:1,5',
            'actif' => 'sometimes|boolean',
            'rights' => 'array',
            'rights.*' => 'integer|between:0,5',
            'users' => 'array',
            'users.*' => 'integer|exists:sw_user,user_id',
        ]);

        $groupe = SwGroupe::create([
            'groupe_nom' => $validated['groupe_nom'],
            'groupe_type' => $validated['groupe_type'],
            'actif' => $request->boolean('actif'),
        ]);

        $this->syncRights($groupe, $request->input('rights', []));
        $groupe->users()->sync($request->input('users', []));

        return redirect()->route('groupes')->with('success', 'Groupe créé avec succès.');
    }

    public function edit(SwGroupe $groupe)
    {
        $groupe->load(['droits', 'users']);
        $users = SwUser::orderBy('user_nom')->orderBy('user_prenom')->get();

        $rights = $this->formatRights($groupe);

        return view('qlio.groupes-edit', [
            'groupe' => $groupe,
            'modules' => $this->modules,
            'levels' => $this->levelLabels,
            'types' => $this->typeOptions,
            'users' => $users,
            'rights' => $rights,
        ]);
    }

    public function update(Request $request, SwGroupe $groupe)
    {
        $validated = $request->validate([
            'groupe_nom' => 'required|string|max:30',
            'groupe_type' => 'required|integer|between:1,5',
            'actif' => 'sometimes|boolean',
            'rights' => 'array',
            'rights.*' => 'integer|between:0,5',
            'users' => 'array',
            'users.*' => 'integer|exists:sw_user,user_id',
        ]);

        $groupe->update([
            'groupe_nom' => $validated['groupe_nom'],
            'groupe_type' => $validated['groupe_type'],
            'actif' => $request->boolean('actif'),
        ]);

        $this->syncRights($groupe, $request->input('rights', []));
        $groupe->users()->sync($request->input('users', []));

        return redirect()->route('groupes')->with('success', 'Groupe mis à jour avec succès.');
    }

    public function destroy(SwGroupe $groupe)
    {
        $groupe->users()->detach();
        SwDroit::where('target_type', 'group')->where('target_id', $groupe->groupe_id)->delete();
        $groupe->delete();

        return redirect()->route('groupes')->with('success', 'Groupe supprimé avec succès.');
    }

    private function syncRights(SwGroupe $groupe, array $rights): void
    {
        foreach (array_keys($this->modules) as $module) {
            $level = isset($rights[$module]) ? (int) $rights[$module] : 0;

            if ($level > 0) {
                SwDroit::updateOrCreate(
                    [
                        'target_type' => 'group',
                        'target_id' => $groupe->groupe_id,
                        'module' => $module,
                    ],
                    ['niveau' => $level]
                );
            } else {
                SwDroit::where('target_type', 'group')
                    ->where('target_id', $groupe->groupe_id)
                    ->where('module', $module)
                    ->delete();
            }
        }
    }

    private function formatRights(SwGroupe $groupe): array
    {
        $rights = [];

        foreach (array_keys($this->modules) as $module) {
            $rights[$module] = optional(
                $groupe->droits->firstWhere('module', $module)
            )->niveau ?? 0;
        }

        return $rights;
    }
}
