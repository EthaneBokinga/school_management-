<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'classe_id',
        'annee_id',
        'date_inscription',
        'type_inscription',
        'statut_paiement'
    ];

    protected $casts = [
        'date_inscription' => 'datetime'
    ];

    // Relations
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function annee()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'inscription_id');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'inscription_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'inscription_id');
    }
    // Ajouter cette relation
public function echeances()
{
    return $this->hasMany(EcheancePaiement::class, 'inscription_id');
}

    // Scopes
    public function scopeAnneeActive($query)
    {
        return $query->whereHas('annee', function($q) {
            $q->where('est_active', true);
        });
    }

    // Accesseurs
    public function getMontantTotalPayeAttribute()
    {
        return $this->paiements->sum('montant_paye');
    }

    public function getResteAPayerTotalAttribute()
    {
        $frais = $this->classe->frais_scolarite ?? 0;
        return $frais - $this->montant_total_paye;
    }
}