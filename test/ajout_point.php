<?php
namespace App;
use Exception;
require __DIR__ . '../../bootstrap.php';

$zone = $entityManager->getRepository(Zone::class)->find(2);
$point = new Point();
$point->setNom_point('Point E');
$zone->setPoint($point);
$entityManager->flush();
