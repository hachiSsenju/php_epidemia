<?php 
use App\Point;
use App\Zone;
require_once '../bootstrap.php';

// Get ID from POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : null;

if ($id === null) {
    echo "<p class='alert alert-danger'>Erreur : Aucun ID reçu.</p>";
    
}

// Fetch the zone by ID
$zone = $entityManager->getRepository(Zone::class)->find($id);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Points - EPIDEMIA</title>
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
    <h2 class="text-center">Gestion des Points</h2>
    <a href="ajouter_point.php" class="btn btn-primary mb-3">Ajouter un Point</a>
    
    <?php if ($zone && count($zone->getPoint()) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zone->getPoint() as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p->getId()) ?></td>
                    <td><?= htmlspecialchars($p->getNom_point()) ?></td>
                    <td>
                        <!-- Modifier -->
                        <form action="modif-point.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($p->getId()) ?>">
                            <button class='btn btn-warning btn-sm' type="submit">Modifier</button>
                        </form>

                        <!-- Supprimer -->
                        <form action="supp-point.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($p->getId()) ?>">
                            <button class='btn btn-danger btn-sm' type="submit">Supprimer</button>
                        </form>

                        <!-- Voir Zones -->
                       
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-warning">Aucun point trouvé pour cette zone.</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Retour</a>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
