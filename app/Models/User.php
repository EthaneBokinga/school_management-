<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être remplis en masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'reference_id',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function logs()
    {
        return $this->hasMany(LogActivite::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    // Méthodes utilitaires
    public function isAdmin()
    {
        return $this->role && $this->role->nom_role === 'Admin';
    }

    public function isProf()
    {
        return $this->role && $this->role->nom_role === 'Prof';
    }

    public function isEleve()
    {
        return $this->role && $this->role->nom_role === 'Eleve';
    }

    public function isParent()
    {
        return $this->role && $this->role->nom_role === 'Parent';
    }

    // Relation polymorphique
    public function getProfileAttribute()
    {
        if ($this->isEleve()) {
            return Etudiant::find($this->reference_id);
        }
        if ($this->isProf()) {
            return Enseignant::find($this->reference_id);
        }
        return null;
    }
}
