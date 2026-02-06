<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
  use HasFactory;

    protected $fillable = [
        'nom_classe',
        'niveau',
        'frais_scolarite'
    ];

    protected $casts = [
        'frais_scolarite' => 'decimal:2'
    ];

    // Relations
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'classe_id');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'classe_id');
    }

    // Accesseur pour compter les étudiants
    public function getEtudiantsCountAttribute()
    {
        return $this->inscriptions()
            ->whereHas('annee', function($q) {
                $q->where('est_active', true);
            })
            ->count();
    }
}
