<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$point=$entityManager->getRepository(Point::class)->find(4);
$zone=$entityManager->getRepository(Zone::class)->find(2);

$point->setNom_point("Hamdalay");
$zone->setPoint($point);
$entityManager->flush();
