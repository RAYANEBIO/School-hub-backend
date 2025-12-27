<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    // Une série peut avoir plusieurs classes
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }

    // Une série peut avoir plusieurs matières (via le coefficient)
    public function matieres()
    {
    return $this->belongsToMany(Matiere::class, 'serie_matiere')
                ->withPivot('coefficient');
    }

}
?>