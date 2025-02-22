<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$zone=$entityManager->getRepository(Zone::class)->find(2);
echo 'points de la zone: <br/>'. $zone->getNom_zone() . "<br/>";
foreach( $zone->getPoint() as $pt){
    echo' -'. $pt->getNom_point();
}