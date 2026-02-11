<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcheancePaiement extends Model
{
    use HasFactory;

    protected $table = 'echeances_paiement';

    protected $fillable = [
        'inscription_id',
        'mois',
        'montant_echeance',
        'date_limite',
        'statut',
        'montant_paye'
    ];

    protected $casts = [
        'montant_echeance' => 'decimal:2',
        'montant_paye' => 'decimal:2',
        'date_limite' => 'date'
    ];

    // Relations
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }

    // Méthode pour vérifier si en retard
    public function isEnRetard()
    {
        return $this->statut === 'En attente' && $this->date_limite < now();
    }

    // Méthode pour calculer le reste à payer
    public function getResteAttribute()
    {
        return $this->montant_echeance - $this->montant_paye;
    }
}