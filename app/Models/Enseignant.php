<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'specialite',
        'email'
    ];

    // Relations
    public function cours()
    {
        return $this->hasMany(Cours::class, 'enseignant_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'reference_id')
            ->whereHas('role', function($q) {
                $q->where('nom_role', 'Prof');
            });
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}
