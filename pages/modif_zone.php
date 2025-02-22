<?php
// Load dependencies and initialize Doctrine
require_once '../bootstrap.php';

use App\Zone;
use App\Pays;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the ID from GET or POST
$id =$id = $_GET['id'] ?? $_POST['id'] ?? null;
if (!$id) {
    echo "Erreur : ID de la zone manquant.";
    exit();
}

// Fetch the zone from the database
$zone = $entityManager->getRepository(Zone::class)->find($id);

if (!$zone) {
    echo "Erreur : Zone introuvable.";
    exit();
}

// Fetch list of all countries (Pays) for the dropdown
$paysList = $entityManager->getRepository(Pays::class)->findAll();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom_zone'], $_POST['nb_habitants'], $_POST['nb_positif'], $_POST['nb_contamines'], $_POST['status'], $_POST['id_pays'])) {
        
        // Sanitize and assign values
        $nom_zone = trim($_POST['nom_zone']);
        $nb_habitants = (int) $_POST['nb_habitants'];
        $nb_positif = (int) $_POST['nb_positif'];
        $nb_contamines = (int) $_POST['nb_contamines'];
       // $status = trim($_POST['status']);
        $id_pays = (int) $_POST['id_pays'];

        // Find the selected country
        $pays = $entityManager->getRepository(Pays::class)->find($id_pays);
        if (!$pays) {
            echo "<p class='alert alert-danger'>Erreur: Pays non trouvé.</p>";

            
        } else {

            if ($nb_habitants > 0) {
                $percentage = ($nb_contamines / $nb_habitants) * 100;
            } else {
                $percentage = 0;
            }
    
    
            if ($percentage <= 5) {
                $status = 'vert';  
            } elseif ($percentage > 5 && $percentage <= 15) {
                $status = 'orange';  
            } else {
                $status = 'rouge';  
            }
            
            // Update Zone entity
            $zone->setNom_zone($nom_zone);
            $zone->setNb_habitants($nb_habitants);
            $zone->setNb_positif($nb_positif);
            $zone->setNb_contamines($nb_contamines);
            $zone->setStatus($status);
            $zone->setPays($pays);
             $zone->setPercent($percentage);
            // Save to the database
            $entityManager->flush();

            // Redirect to gestionZone.php after successful update
            header("Location: gestionZone.php?success=1");
            exit();
        }
    } else {
        echo "<p class='alert alert-danger'>Erreur : Tous les champs doivent être remplis.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Zone - EPIDEMIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
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

<!-- Form Container -->
<div class="container mt-4">
    <h2 class="text-center">Modifier une Zone</h2>

    <form action="modif_zone.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($zone->getId()) ?>">

        <div class="mb-3">
            <label for="nom_zone" class="form-label">Nom de la zone</label>
            <input type="text" class="form-control" id="nom_zone" name="nom_zone" required value="<?= htmlspecialchars($zone->getNom_zone()) ?>">
        </div>
        <div class="mb-3">
            <label for="nb_habitants" class="form-label">Nombre d'habitants</label>
            <input type="number" class="form-control" id="nb_habitants" name="nb_habitants" required value="<?= htmlspecialchars($zone->getNb_habitants()) ?>">
        </div>
        <div class="mb-3">
            <label for="nb_positif" class="form-label">Nombre de cas positifs</label>
            <input type="number" class="form-control" id="nb_positif" name="nb_positif" required value="<?= htmlspecialchars($zone->getNb_positif()) ?>">
        </div>
        <div class="mb-3">
            <label for="nb_contamines" class="form-label">Nombre de contaminés</label>
            <input type="number" class="form-control" id="nb_contamines" name="nb_contamines" required value="<?= htmlspecialchars($zone->getNb_contamines()) ?>">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status" required>
                <option value="vert" <?= $zone->getStatus() === "vert" ? "selected" : "" ?>>Vert</option>
                <option value="orange" <?= $zone->getStatus() === "orange" ? "selected" : "" ?>>Orange</option>
                <option value="rouge" <?= $zone->getStatus() === "rouge" ? "selected" : "" ?>>Rouge</option>
            </select>
        </div>

        <!-- Select Country -->
        <div class="mb-3">
            <label for="id_pays" class="form-label">Pays</label>
            <select class="form-control" id="id_pays" name="id_pays" required>
                <?php foreach ($paysList as $pays): ?>
                    <option value="<?= $pays->getId(); ?>" <?= ($pays->getId() == $zone->getPays()->getId()) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($pays->getNom_pays()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="gestionZone.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
