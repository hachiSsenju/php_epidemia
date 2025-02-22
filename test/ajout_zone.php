<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$zone= new Zone();
$zone->setNom_zone("Dakar");
$zone->setNb_habitants(100000);
$zone->setNb_positif(1000);
$zone->setStatus("rouge");
$zone->setNb_contamines("900");
$entityManager->persist($zone);
$entityManager->flush();
