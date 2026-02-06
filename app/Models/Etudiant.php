<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
   use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'statut_actuel'
    ];

    protected $casts = [
        'date_naissance' => 'date'
    ];

    // Relations
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'etudiant_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'reference_id')
            ->whereHas('role', function($q) {
                $q->where('nom_role', 'Eleve');
            });
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getInscriptionActiveAttribute()
    {
        return $this->inscriptions()
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->first();
    }
}
