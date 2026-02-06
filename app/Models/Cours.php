<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
   use HasFactory;

    protected $fillable = [
        'enseignant_id',
        'matiere_id',
        'classe_id',
        'annee_id'
    ];

    // Relations
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function annee()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_id');
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class, 'cours_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'cours_id');
    }

    public function devoirs()
    {
        return $this->hasMany(Devoir::class, 'cours_id');
    }

    public function ressources()
    {
        return $this->hasMany(RessourcePedagogique::class, 'cours_id');
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'cours_id');
    }

    // Scopes
    public function scopeAnneeActive($query)
    {
        return $query->whereHas('annee', function($q) {
            $q->where('est_active', true);
        });
    }
}
