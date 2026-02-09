<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessourcePedagogique extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'titre',
        'url_fichier'
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}