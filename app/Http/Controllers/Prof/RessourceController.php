<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\RessourcePedagogique;
use App\Models\Cours;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller
{
    public function index()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $ressources = RessourcePedagogique::with(['cours.matiere', 'cours.classe'])
            ->whereHas('cours', function($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('prof.ressources.index', compact('ressources'));
    }

    public function create()
    {
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        $cours = Cours::with(['matiere', 'classe'])
            ->where('enseignant_id', $enseignant->id)
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->get();
        
        return view('prof.ressources.create', compact('cours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'titre' => 'required|string|max:200',
            'fichier' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:20480' // 20MB max
        ]);

        // Vérifier que le cours appartient bien au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        $cours = Cours::where('id', $validated['cours_id'])
            ->where('enseignant_id', $enseignant->id)
            ->firstOrFail();

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            
            // Générer un nom unique
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Stocker dans storage/app/public/ressources
            $path = $file->storeAs('public/ressources', $filename);
            
            RessourcePedagogique::create([
                'cours_id' => $validated['cours_id'],
                'titre' => $validated['titre'],
                'url_fichier' => Storage::url($path),
                'type_fichier' => $file->getClientOriginalExtension(),
                'taille_fichier' => $file->getSize()
            ]);
        }

        return redirect()->route('prof.ressources.index')
            ->with('success', 'Ressource uploadée avec succès');
    }

    public function destroy(RessourcePedagogique $ressource)
    {
        // Vérifier que la ressource appartient au professeur
        $enseignant = Enseignant::where('email', auth()->user()->email)->firstOrFail();
        
        if ($ressource->cours->enseignant_id !== $enseignant->id) {
            abort(403, 'Action non autorisée');
        }

        // Supprimer le fichier physique
        $filepath = str_replace('/storage/', 'public/', $ressource->url_fichier);
        Storage::delete($filepath);

        // Supprimer l'enregistrement
        $ressource->delete();

        return redirect()->route('prof.ressources.index')
            ->with('success', 'Ressource supprimée avec succès');
    }
}