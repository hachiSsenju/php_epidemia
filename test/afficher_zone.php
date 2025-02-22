<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$pays=$entityManager->getRepository(Pays::class)->find(2);
echo "zones du pays :". $pays->getNom_pays() ."<br>";
foreach($pays->getZone() as $zn){
    echo"-". $zn->getNom_zone();
}
