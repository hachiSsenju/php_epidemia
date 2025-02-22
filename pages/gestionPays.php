<?php 
use App\Pays;
require_once '../bootstrap.php';
                 $pays=$entityManager->getRepository(Pays::class)->findAll();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Pays - EPIDEMIA</title>
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
        <h2 class="text-center">Gestion des Pays</h2>
        <a href="ajouter-pays.php" class="btn btn-primary mb-3">Ajouter un Pays</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
        
  

            <?php foreach($pays as $p): ?>
<tr>
   <td><?= $p->getId() ?></td>
   <td><?= $p->getNom_pays() ?></td>
   <td>
       
        <form action="modifier-pays.php" method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?= $p->getId() ?>">
            <button class='btn btn-warning btn-sm' type="submit">Modifier</button>
        </form>

 
        <form action="supp-pays.php" method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?= $p->getId() ?>">
            <button class='btn btn-danger btn-sm' type="submit">Supprimer</button>
        </form>

       
        <form action="gestionZone.php" method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?= $p->getId() ?>">
            <button class='btn btn-info btn-sm' type="submit">Voir Zones</button>
        </form>
   </td>
</tr>
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
