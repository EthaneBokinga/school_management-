<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
  use HasFactory;

    protected $fillable = [
        'nom_matiere',
        'code_matiere',
        'coefficient'
    ];

    protected $casts = [
        'coefficient' => 'integer'
    ];

    // Relations
    public function cours()
    {
        return $this->hasMany(Cours::class, 'matiere_id');
    }
}
