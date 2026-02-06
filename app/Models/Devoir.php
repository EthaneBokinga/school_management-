<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
     use HasFactory;

    protected $fillable = [
        'cours_id',
        'titre',
        'description',
        'date_limite'
    ];

    protected $casts = [
        'date_limite' => 'date'
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}
