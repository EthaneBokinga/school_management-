<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnneeScolaire extends Model
{
    use HasFactory;

    protected $table = 'annees_scolaires';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'est_active',
         'statut' 
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'est_active' => 'boolean'
    ];

    // Relations
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'annee_id');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'annee_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }
}
