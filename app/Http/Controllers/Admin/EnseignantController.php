<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::withCount(['cours' => function($q) {
            $q->whereHas('annee', function($query) {
                $query->where('est_active', true);
            });
        }])->paginate(20);
        
        return view('admin.enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('admin.enseignants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'specialite' => 'required|string|max:100',
            'email' => 'required|email|unique:enseignants',
            'create_account' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        
        try {
            $enseignant = Enseignant::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'specialite' => $validated['specialite'],
                'email' => $validated['email']
            ]);

            // Créer un compte utilisateur si demandé
            if ($request->has('create_account') && $request->create_account) {
                $roleProf = Role::where('nom_role', 'Prof')->first();
                
                User::create([
                    'name' => $enseignant->nom_complet,
                    'email' => $validated['email'],
                    'password' => Hash::make('password'),
                    'role_id' => $roleProf->id,
                    'reference_id' => $enseignant->id
                ]);
            }

            DB::commit();

            return redirect()->route('admin.enseignants.index')
                ->with('success', 'Enseignant créé avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $enseignant = Enseignant::with([
            'cours.classe',
            'cours.matiere',
            'cours.annee'
        ])->findOrFail($id);

        return view('admin.enseignants.show', compact('enseignant'));
    }

    public function edit(string $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        return view('admin.enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'specialite' => 'required|string|max:100',
            'email' => 'required|email|unique:enseignants,email,' . $id
        ]);

        $enseignant = Enseignant::findOrFail($id);
        $enseignant->update($validated);

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Enseignant mis à jour avec succès');
    }

    public function destroy(string $id)
    {
        $enseignant = Enseignant::findOrFail($id);
        
        // Supprimer le compte utilisateur associé
        User::where('reference_id', $enseignant->id)
            ->whereHas('role', function($q) {
                $q->where('nom_role', 'Prof');
            })->delete();
        
        $enseignant->delete();

        return redirect()->route('admin.enseignants.index')
            ->with('success', 'Enseignant supprimé avec succès');
    }
}