<?php 
use App\Pays;
require_once '../bootstrap.php';

// Get ID from POST request
$id = isset($_POST['id']) ? intval($_POST['id']) : null;

// Fetch country data
if ($id !== null) {
    $pays = $entityManager->getRepository(Pays::class)->find($id);
    $paysList = $pays ? [$pays] : [];
} else {
    $paysList = $entityManager->getRepository(Pays::class)->findAll();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Pays - EPIDEMIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-vert { background-color: #28a745; color: white; padding: 5px; border-radius: 5px; }
        .status-orange { background-color: #fd7e14; color: white; padding: 5px; border-radius: 5px; }
        .status-rouge { background-color: #dc3545; color: white; padding: 5px; border-radius: 5px; }
    </style>
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
    <h2 class="text-center">Gestion des Zones</h2>
    <a href="ajouter-zone.php" class="btn btn-primary mb-3">Ajouter une Zone</a>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Zone</th>
                <th>Status</th>
                <th>Nombre de Positifs</th>
                <th>ID Pays</th>
                <th>Nom Pays</th>
                <th>Nombre d'Habitants</th>
                <th>Nombre de Contaminés</th>
                <th>Taux de contamination</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach($paysList as $p): ?>
                <?php foreach($p->getZone() as $zn): ?>
                    <?php 
                        
                        $status = htmlspecialchars($zn->getStatus());
                        $statusClass = "status-{$status}";
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($zn->getId()) ?></td>
                        <td><?= htmlspecialchars($zn->getNom_zone()) ?></td>
                        <td class=<?=$statusClass?>><?=$zn->getStatus()?></td>
                        <!-- <td><span class="<?= $statusClass ?>"><?= strtoupper($status) ?></span></td> -->
                        <td><?= htmlspecialchars($zn->getNb_positif()) ?></td>
                        <td><?= htmlspecialchars($zn->getPays()->getId()) ?></td>
                        <td><?= htmlspecialchars($zn->getPays()->getNom_pays()) ?></td>
                        <td><?= htmlspecialchars($zn->getNb_habitants()) ?></td>
                        <td><?= htmlspecialchars($zn->getNb_contamines()) ?></td>
                        <td><?= htmlspecialchars($zn->getPercent()) ?>%</td>
                        <td>
                            <!-- Modifier Button Form -->
                            <form action="modif_zone.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($zn->getId()) ?>">
                                <button class='btn btn-warning btn-sm' type="submit">Modifier</button>
                            </form>

                            <!-- Supprimer Button Form -->
                            <form action="supp-zone.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($zn->getId()) ?>">
                                <button class='btn btn-danger btn-sm' type="submit">Supprimer</button>
                            </form>

                            <!-- Voir Zones Button Form -->
                            <form action="gestionPoint.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($zn->getId()) ?>">
                                <button class='btn btn-info btn-sm' type="submit">Afficher Points</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Retour</a>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
