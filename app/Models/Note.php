<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'cours_id',
        'type_examen_id',
        'valeur_note',
        'date_saisie'
    ];

    protected $casts = [
        'valeur_note' => 'decimal:2',
        'date_saisie' => 'datetime'
    ];

    // Relations
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function typeExamen()
    {
        return $this->belongsTo(TypeExamen::class, 'type_examen_id');
    }
}
