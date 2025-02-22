<?php

require_once '../bootstrap.php';
use App\Zone;
use App\Pays; 

$paysRepository = $entityManager->getRepository(Pays::class);
$paysList = $paysRepository->findAll(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom_zone'], $_POST['nb_habitants'], $_POST['nb_positif'], $_POST['nb_contamines'], $_POST['id_pays'])) {
        
        $nom_zone = trim($_POST['nom_zone']);
        $nb_habitants = (int) $_POST['nb_habitants'];
        $nb_positif = (int) $_POST['nb_positif'];
        $nb_contamines = (int) $_POST['nb_contamines'];
        $id_pays = (int) $_POST['id_pays'];

        $pays = $paysRepository->find($id_pays);
        if (!$pays) {
            echo "Erreur: Pays non trouvé.";
            exit();
        }
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
        

        // Create a new Zone entity and set its properties
        $zone = new Zone();
        $zone->setNom_zone($nom_zone);
        $zone->setNb_habitants($nb_habitants);
        $zone->setNb_positif($nb_positif);
        $zone->setNb_contamines($nb_contamines);
        $zone->setStatus($status); 
        $zone->setPays($pays);
        $zone->setPercent($percentage);

        // Persist the zone to the database
        $entityManager->persist($zone);
        $entityManager->flush();

        // Redirect to the zone management page with success message
        header("Location: gestionZone.php?success=1");
        exit();
    } else {
        echo "Erreur: Tous les champs doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Zone - EPIDEMIA</title>
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
    <h2 class="text-center">Ajouter une Zone</h2>
    
    <form action="ajouter-zone.php" method="POST">
        <div class="mb-3">
            <label for="nom_zone" class="form-label">Nom de la zone</label>
            <input type="text" class="form-control" id="nom_zone" name="nom_zone" required>
        </div>
        <div class="mb-3">
            <label for="nb_habitants" class="form-label">Nombre d'habitants</label>
            <input type="number" class="form-control" id="nb_habitants" name="nb_habitants" required>
        </div>
        <div class="mb-3">
            <label for="nb_positif" class="form-label">Nombre de cas positifs</label>
            <input type="number" class="form-control" id="nb_positif" name="nb_positif" required>
        </div>
        <div class="mb-3">
            <label for="nb_contamines" class="form-label">Nombre de contaminés</label>
            <input type="number" class="form-control" id="nb_contamines" name="nb_contamines" required>
        </div>

        <!-- Removed the status selection, as it is calculated automatically -->
        
        <div class="mb-3">
            <label for="id_pays" class="form-label">Pays</label>
            <select class="form-control" id="id_pays" name="id_pays" required>
                <option value="">Sélectionnez un pays</option>
                <?php foreach ($paysList as $pays): ?>
                    <option value="<?= $pays->getId(); ?>"><?= htmlspecialchars($pays->getNom_pays()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="gestionZone.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2025 EPIDEMIA - Tous droits réservés</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
