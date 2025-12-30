<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;
use App\Services\ClasseService;
use App\Models\Serie;


class ClasseController extends Controller
{
    protected $classeService;

    // Injection du service
    public function __construct(ClasseService $classeService)
    {
        $this->classeService = $classeService;
    }

    //Afficher toutes les classes
    public function index()
    {
        $classes = Classe::all();
        $series = Serie::all(); // récupère toutes les séries
        return view('classes.index', compact('classes', 'series'));
    }

    //Afficher une classe en détail
    public function show($id)
    {
        $classe = Classe::with('eleves', 'serie')->findOrFail($id);
        $nbEleves = $this->classeService->countEleves($classe);
        $matieres = $this->classeService->getMatieres($classe);

        return view('classes.show', compact('classe', 'nbEleves', 'matieres'));
    }

    //Créer une nouvelle classe
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'annee_scolaire' => 'required|string',
            'description' => 'nullable|string',
            'serie_id' => 'required|exists:series,id',
        ]);

        Classe::create($validated);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès');
    }

    //Inscrire un élève dans une classe
    public function inscrireEleve(Request $request, $classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $eleve = Eleve::findOrFail($request->eleve_id);

        if (!$this->classeService->inscrireEleve($classe, $eleve)) {
            return back()->with('error', 'Classe pleine, inscription impossible');
        }

        return back()->with('success', 'Élève inscrit avec succès');
    }

    //Transférer un élève vers une autre classe
    public function transfererEleve(Request $request, $eleveId)
    {
        $eleve = Eleve::findOrFail($eleveId);
        $nouvelleClasse = Classe::findOrFail($request->nouvelle_classe_id);

        $this->classeService->transfererEleve($eleve, $nouvelleClasse);

        return back()->with('success', 'Élève transféré avec succès');
    }

    //Lister les classes par année scolaire
    public function listByAnnee($annee)
    {
        $classes = $this->classeService->listByAnnee($annee);
        return view('classes.index', compact('classes'));
    }

    //Exporter les données d’une classe
    public function exporter($id)
    {
        $classe = Classe::findOrFail($id);
        $data = $this->classeService->exporterClasse($classe);

        return response()->json($data);
    }

    //Statistiques par série
    public function statsParSerie()
    {
        $stats = $this->classeService->statsParSerie();
        return response()->json($stats);
    }
}