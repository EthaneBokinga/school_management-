<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
     use HasFactory;

    protected $fillable = [
        'inscription_id',
        'cours_id',
        'date_absence',
        'est_justifie'
    ];

    protected $casts = [
        'date_absence' => 'date',
        'est_justifie' => 'boolean'
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
}
