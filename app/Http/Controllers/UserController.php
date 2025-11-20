<?php

namespace App\Http\Controllers;

use App\Models\SwUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected function userTypes(): array
    {
        return [
            1 => 'Étudiant',
            2 => 'Tuteur pédagogique',
            3 => 'Tuteur entreprise',
            4 => 'Administrateur',
        ];
    }

    public function index(Request $request)
    {
        $query = SwUser::query();

        // Recherche par nom ou prénom
        if ($request->filled('search')) {
            $pattern = $this->convertWildcard($request->search);
            $query->where(function($q) use ($pattern) {
                $q->where('user_nom', 'like', $pattern)
                  ->orWhere('user_prenom', 'like', $pattern);
            });
        }
        
        // Filtre par type d'utilisateur
        if ($request->filled('user_type_id') && array_key_exists($request->user_type_id, $this->userTypes())) {
            $query->where('user_type_id', $request->user_type_id);
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
            }
        }

        $users = $query->orderBy('user_nom')->orderBy('user_prenom')->paginate(10);
        $users->appends($request->query());

        $userTypes = $this->userTypes();

        return view('qlio.users', compact('users', 'userTypes'));
    }

    public function create()
    {
        $userTypes = $this->userTypes();
        return view('qlio.users-create', compact('userTypes'));
    }

    public function store(Request $request)
    {
        $userTypes = $this->userTypes();

        $validated = $request->validate([
            'user_nom' => 'required|string|max:255',
            'user_prenom' => 'required|string|max:255',
            'user_login' => ['nullable', 'string', 'max:100', Rule::unique('sw_user', 'user_login')],
            'user_mel' => ['nullable', 'email', 'max:255', Rule::unique('sw_user', 'user_mel')],
            'user_tel' => 'nullable|string|max:40',
            'user_tel_port' => 'nullable|string|max:40',
            'user_adresse' => 'nullable|string|max:255',
            'user_adresse_bis' => 'nullable|string|max:255',
            'user_cp' => 'nullable|string|max:20',
            'user_commune' => 'nullable|string|max:100',
            'user_bp' => 'nullable|string|max:50',
            'user_num' => 'nullable|string|max:100',
            'user_type_id' => ['required', Rule::in(array_keys($userTypes))],
            'actif' => 'sometimes|boolean',
        ]);

        $validated['actif'] = $request->boolean('actif');
        $validated['createur_id'] = 1; // TODO: remplacer par l'ID utilisateur connecté
        $validated['ctime'] = now();
        $validated['utime'] = now();

        SwUser::create($validated);

        return redirect()->route('users')->with('success', 'Utilisateur créé avec succès');
    }

    public function edit(SwUser $user)
    {
        $userTypes = $this->userTypes();
        return view('qlio.users-edit', compact('user', 'userTypes'));
    }

    public function update(Request $request, SwUser $user)
    {
        $userTypes = $this->userTypes();

        $validated = $request->validate([
            'user_nom' => 'required|string|max:255',
            'user_prenom' => 'required|string|max:255',
            'user_login' => ['nullable', 'string', 'max:100', Rule::unique('sw_user', 'user_login')->ignore($user->user_id, 'user_id')],
            'user_mel' => ['nullable', 'email', 'max:255', Rule::unique('sw_user', 'user_mel')->ignore($user->user_id, 'user_id')],
            'user_tel' => 'nullable|string|max:40',
            'user_tel_port' => 'nullable|string|max:40',
            'user_adresse' => 'nullable|string|max:255',
            'user_adresse_bis' => 'nullable|string|max:255',
            'user_cp' => 'nullable|string|max:20',
            'user_commune' => 'nullable|string|max:100',
            'user_bp' => 'nullable|string|max:50',
            'user_num' => 'nullable|string|max:100',
            'user_type_id' => ['required', Rule::in(array_keys($userTypes))],
            'actif' => 'sometimes|boolean',
        ]);

        $validated['actif'] = $request->boolean('actif');
        $validated['utime'] = now();

        $user->update($validated);

        return redirect()->route('users')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(SwUser $user)
    {
        $user->delete();

        return redirect()->route('users')->with('success', 'Utilisateur supprimé avec succès');
    }

    protected function convertWildcard(string $input): string
    {
        $escaped = addcslashes($input, '%_\\');
        $converted = str_replace(['*', '?'], ['%', '_'], $escaped);
        return $converted === '' ? '%' : '%' . $converted . '%';
    }
}
