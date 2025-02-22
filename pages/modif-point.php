<?php
use App\Point;
use App\Zone;
require_once '../bootstrap.php';

// Retrieve the ID from GET or POST
$id = $_GET['id'] ?? $_POST['id'] ?? null;

// If ID is missing, redirect to gestionPoint.php
if (!$id) {
    header("Location: gestionPoint.php");
    exit;
}

// Retrieve the Point entity
$point = $entityManager->getRepository(Point::class)->find($id);
$zones = $entityManager->getRepository(Zone::class)->findAll(); // Get all zones

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['nom_point'] ?? null;
    $zoneId = $_POST['zone_id'] ?? null;

    if ($point && $name && $zoneId) {
        $zone = $entityManager->getRepository(Zone::class)->find($zoneId);

        if ($zone) {
            $point->setNom_point($name);
            $point->setZone($zone); // Update the point's zone
            $entityManager->flush();
            
            // Redirect after successful update
            header("Location: gestionPoint.php?success=1");
            exit;
        } else {
            $error = "Zone introuvable.";
        }
    } else {
        $error = "Point introuvable ou données invalides.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Point - EPIDEMIA</title>
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
    <h2 class="text-center">Modifier un Point</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="modif-point.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($point->getId()) ?>">

        <!-- Nom du Point -->
        <div class="mb-3">
            <label for="nom_point" class="form-label">Nom du Point</label>
            <input type="text" class="form-control" id="nom_point" name="nom_point" required value="<?= htmlspecialchars($point->getNom_point()) ?>">
        </div>

        <!-- Sélection de la Zone -->
        <div class="mb-3">
            <label for="zone_id" class="form-label">Zone</label>
            <select class="form-select" id="zone_id" name="zone_id" required>
                <?php foreach ($zones as $zone): ?>
                    <option value="<?= $zone->getId() ?>" <?= ($point->getZone()->getId() == $zone->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($zone->getNom_zone()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="gestionPoint.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
