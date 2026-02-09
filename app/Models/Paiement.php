<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
     use HasFactory;

    protected $fillable = [
        'inscription_id',
        'montant_paye',
        'reste_a_payer',
        'date_paiement'
    ];

    protected $casts = [
        'montant_paye' => 'decimal:2',
        'reste_a_payer' => 'decimal:2',
        'date_paiement' => 'datetime'
    ];

    // Relations
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }
}
