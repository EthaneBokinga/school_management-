<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeExamen extends Model
{
    use HasFactory;

    protected $table = 'types_examens';

    protected $fillable = [
        'libelle'
    ];

    // Relations
    public function notes()
    {
        return $this->hasMany(Note::class, 'type_examen_id');
    }
}
