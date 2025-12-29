<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="mb-4">Gestion des classes</h1>

    {{-- Formulaire d'ajout --}}
    <form method="POST" action="/classes" class="mb-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom de la classe</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Année scolaire</label>
            <input type="text" name="annee_scolaire" class="form-control" placeholder="2024-2025" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>


        <div class="mb-3">
            <label class="form-label">Série</label>
            <select name="serie_id" class="form-select">
                <option value="">-- Sélectionner une série --</option>
                @foreach($series as $serie)
                    <option value="{{ $serie->id }}">{{ $serie->nom }}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    {{-- Liste des classes --}}
    <h2>Liste des classes</h2>

    @if($classes->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Classe</th>
                    <th>Année</th>
                    <th>Série</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $classe)
                    <tr>
                        <td>{{ $classe->id }}</td>
                        <td>{{ $classe->nom }}</td>
                        <td>{{ $classe->annee_scolaire }}</td>
                        <td>{{ $classe->serie->nom ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune classe enregistrée.</p>
    @endif

</body>
</html>
