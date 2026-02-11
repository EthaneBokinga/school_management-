<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'type_examen_id',
        'titre',
        'description',
        'date_examen',
        'heure_debut',
        'heure_fin',
        'salle_id',
        'statut'
    ];

    protected $casts = [
        'date_examen' => 'date',
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function typeExamen()
    {
        return $this->belongsTo(TypeExamen::class, 'type_examen_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    // Méthode pour vérifier si l'examen est passé
    public function isTermine()
    {
        return $this->date_examen < now()->toDateString();
    }

    // Méthode pour vérifier si l'examen est aujourd'hui
    public function isAujourdhui()
    {
        return $this->date_examen->isToday();
    }
}