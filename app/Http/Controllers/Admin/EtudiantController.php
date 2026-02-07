<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with(['inscriptions.classe', 'inscriptions.annee'])
            ->where('statut_actuel', 'Inscrit')
            ->paginate(20);
        
        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('admin.etudiants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:20|unique:etudiants',
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
            'create_account' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        
        try {
            $etudiant = Etudiant::create([
                'matricule' => $validated['matricule'],
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'date_naissance' => $validated['date_naissance'],
                'sexe' => $validated['sexe'],
                'statut_actuel' => 'Inscrit'
            ]);

            // Créer un compte utilisateur si demandé
            if ($request->has('create_account') && $request->create_account) {
                $roleEleve = Role::where('nom_role', 'Eleve')->first();
                
                User::create([
                    'name' => $etudiant->nom_complet,
                    'email' => strtolower($validated['matricule']) . '@eleve.school.cg',
                    'password' => Hash::make('password'),
                    'role_id' => $roleEleve->id,
                    'reference_id' => $etudiant->id
                ]);
            }

            DB::commit();

            return redirect()->route('admin.etudiants.index')
                ->with('success', 'Étudiant créé avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id)
    {
        $etudiant = Etudiant::with([
            'inscriptions.classe',
            'inscriptions.annee',
            'inscriptions.notes.cours.matiere',
            'inscriptions.absences',
            'inscriptions.paiements'
        ])->findOrFail($id);

        return view('admin.etudiants.show', compact('etudiant'));
    }

    public function edit(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('admin.etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:20|unique:etudiants,matricule,' . $id,
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
            'statut_actuel' => 'required|in:Inscrit,Diplomé,Quitté'
        ]);

        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update($validated);

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès');
    }

    public function destroy(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        
        // Supprimer le compte utilisateur associé
        User::where('reference_id', $etudiant->id)
            ->whereHas('role', function($q) {
                $q->where('nom_role', 'Eleve');
            })->delete();
        
        $etudiant->delete();

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès');
    }

    public function reinscription(string $id)
    {
        $etudiant = Etudiant::with('inscriptions.classe')->findOrFail($id);
        return view('admin.etudiants.reinscription', compact('etudiant'));
    }
}