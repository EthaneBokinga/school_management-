<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
     use HasFactory;

    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'cours_id',
        'salle_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin'
    ];

    protected $casts = [
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i'
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }
}
