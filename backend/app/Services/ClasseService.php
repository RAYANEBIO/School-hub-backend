<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use Illuminate\Support\Collection;

class ClasseService
{
    // 1. Gestion des élèves
     

    // Compter les élèves d’une classe
    public function countEleves(Classe $classe): int
    {
        return $classe->eleves()->count();
    }

    // Lister les élèves avec filtres (sexe, âge, statut)
    public function listEleves(Classe $classe, array $filters = []): Collection
    {
        $query = $classe->eleves();

        if (isset($filters['sexe'])) {
            $query->where('sexe', $filters['sexe']);
        }
        if (isset($filters['age'])) {
            $query->where('age', $filters['age']);
        }
        if (isset($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        return $query->get();
    }

    // Inscrire un nouvel élève (vérifier capacité max)
    public function inscrireEleve(Classe $classe, Eleve $eleve): bool
    {
        if ($classe->capacite && $classe->eleves()->count() >= $classe->capacite) {
            return false; 
        }
        $classe->eleves()->save($eleve);
        return true;
    }

    // Transférer un élève d’une classe à une autre
    public function transfererEleve(Eleve $eleve, Classe $nouvelleClasse): void
    {
        $eleve->classe()->associate($nouvelleClasse);
        $eleve->save();
    }

    // 2. Gestion pédagogique
     

    // Lister les matières associées à une classe (via Série)
    public function getMatieres(Classe $classe): Collection
    {
        return $classe->serie->matieres;
    }

    // Calculer les coefficients des matières pour une classe donnée
    public function getCoefficients(Classe $classe): array
    {
        return $classe->serie->matieres->mapWithKeys(function ($matiere) {
            return [$matiere->nom => $matiere->pivot->coefficient];
        })->toArray();
    }

    // Attribuer un professeur principal
    public function attribuerProfPrincipal(Classe $classe, int $profId): void
    {
        $classe->prof_principal_id = $profId;
        $classe->save();
    }

    //3. Gestion administrative


    // Vérifier la capacité
    public function isFull(Classe $classe): bool
    {
        return $classe->capacite && $classe->eleves()->count() >= $classe->capacite;
    }

    // Lister les classes par année scolaire
    public function listByAnnee(string $annee): Collection
    {
        return Classe::where('annee_scolaire', $annee)->get();
    }

    // 4. Services transversaux


    // Exporter les données d’une classe
    public function exporterClasse(Classe $classe): array
    {
        return [
            'classe' => $classe->nom,
            'annee_scolaire' => $classe->annee_scolaire,
            'eleves' => $classe->eleves()->pluck('nom'),
            'matieres' => $this->getMatieres($classe)->pluck('nom'),
        ];
    }

    // Statistiques : nombre d’élèves par série
    public function statsParSerie(): array
    {
        return Classe::with('serie', 'eleves')
            ->get()
            ->groupBy('serie.nom')
            ->map(fn($classes) => $classes->sum(fn($c) => $c->eleves->count()))
            ->toArray();
    }

    // Validation 
    public function validateUniqueNom(Classe $classe): bool
    {
        return !Classe::where('nom', $classe->nom)
            ->where('niveau_id', $classe->niveau_id)
            ->exists();
    }
}
?>