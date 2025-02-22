<?php
use App\Zone;  // Assuming Zone is the entity you're working with
use App\Point; // Assuming Point is another entity related to your form submission
require_once '../bootstrap.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nom_point'];  // Get the name of the point
    $zoneId = $_POST['id_zone'];  // Get the selected zone ID
    
    // Ensure that zoneId is valid
    if ($zoneId && $name) {
        $zone = $entityManager->getRepository(Zone::class)->find($zoneId);  // Fetch Zone by its ID
        if ($zone) {
            // Create a new Point and associate it with the selected Zone
            $point = new Point();
            $point->setNom_point($name);  // Set the name of the point
            $point->setZone($zone);  // Associate the zone with the point

            // Persist the data to the database
            $entityManager->persist($point);
            $entityManager->flush();

            // Redirect after successful form submission
            header('Location: gestionZone.php');
            exit;
        } else {
            echo "<p class='alert alert-danger'>Zone invalide.</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Veuillez remplir tous les champs.</p>";
    }
}

// Fetch all zones to populate the select options
$zonesList = $entityManager->getRepository(Zone::class)->findAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Point - EPIDEMIA</title>
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
    <h2 class="text-center">Ajouter un Point de Surveillance</h2>
    <form action="./ajouter_point.php" method="POST">
        <div class="mb-3">
            <label for="nom_point" class="form-label">Nom du Point de Surveillance</label>
            <input type="text" class="form-control" id="nom_point" name="nom_point" required>
        </div>

        <div class="mb-3">
            <label for="id_zone" class="form-label">Zone</label>
            <select class="form-control" id="id_zone" name="id_zone" required>
                <option value="">Sélectionnez une Zone</option>
                <?php foreach ($zonesList as $zone): ?>
                    <option value="<?= $zone->getId(); ?>"><?= htmlspecialchars($zone->getNom_zone()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="gestionPoint.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
