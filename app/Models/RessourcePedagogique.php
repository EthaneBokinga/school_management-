<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessourcePedagogique extends Model
{
    use HasFactory;

    protected $table = 'ressources_pedagogiques';

    protected $fillable = [
        'cours_id',
        'titre',
        'description',
        'url_fichier',
        'type_fichier',
        'taille_fichier'
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    // Accesseur pour formater la taille
    public function getTailleFormateeAttribute()
    {
        $bytes = $this->taille_fichier;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Méthode pour obtenir l'icône selon le type
    public function getIconeAttribute()
    {
        $icons = [
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc' => 'fas fa-file-word text-primary',
            'docx' => 'fas fa-file-word text-primary',
            'ppt' => 'fas fa-file-powerpoint text-warning',
            'pptx' => 'fas fa-file-powerpoint text-warning',
            'xls' => 'fas fa-file-excel text-success',
            'xlsx' => 'fas fa-file-excel text-success',
            'zip' => 'fas fa-file-archive text-secondary',
            'rar' => 'fas fa-file-archive text-secondary',
        ];

        return $icons[$this->type_fichier] ?? 'fas fa-file text-muted';
    }
}