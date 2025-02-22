<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$pays= new Pays();
$pays->setNom_pays("senegal");
$entityManager->persist($pays);
$entityManager->flush();
