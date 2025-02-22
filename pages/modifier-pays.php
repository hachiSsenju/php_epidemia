<?php
use App\Pays;
require_once '../bootstrap.php';

// Retrieve the ID from GET or POST
$id = $_GET['id'] ?? $_POST['id'] ?? null;

// If ID is missing, redirect to gestionPays.php
if (!$id) {
    header("Location: gestionPays.php");
    exit;
}

// Retrieve the Pays entity
$pays = $entityManager->getRepository(Pays::class)->find($id);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['nom_pays'] ?? null;

    if ($pays && $name) {
        $pays->setNom_pays($name);
        $entityManager->flush();
        
        // Redirect after successful update
        header("Location: gestionPays.php?success=1");
        exit;
    } else {
        $error = "Pays introuvable ou nom invalide.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Pays - EPIDEMIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">EPIDEMIA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="gestionPays.php">Pays</a></li>
                <li class="nav-item"><a class="nav-link" href="gestionZone.php">Zones</a></li>
                
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Modifier un Pays</h2>

   

    <form action="modifier-pays.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($pays->getId()) ?>">

        <div class="mb-3">
            <label for="nom_pays" class="form-label">Nom du Pays</label>
            <input type="text" class="form-control" id="nom_pays" name="nom_pays" required value="<?= htmlspecialchars($pays->getNom_pays()) ?>">
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="gestionPays.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
