<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'annee_scolaire',
        'description',
        'serie_id', 
    ];


    // Relation avec les élèves
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    // Relation avec les matières (via le coefficient)
    public function matieres()
    {
    return $this->belongsToMany(Matiere::class, 'classe_matiere')
                ->withPivot('coefficient');
    }

    // Relation avec la série
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    
}
?>