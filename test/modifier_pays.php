<?php
namespace App;
require __DIR__ . '../../bootstrap.php';

$pays=$entityManager->getRepository(Pays::class)->find(2);
$pays->setNom_pays("Guinée");
$entityManager->flush();