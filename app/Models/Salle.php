<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
   use HasFactory;

    protected $fillable = [
        'nom_salle',
        'type'
    ];

    // Relations
    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class, 'salle_id');
    }
}
