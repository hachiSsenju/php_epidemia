<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$pays=$entityManager->getRepository(Pays::class)->findAll();

echo 'Pays: <br/>';
foreach($pays as $p){
    echo 'nom: '. $p->getNom_pays() ."<br/>";
}
